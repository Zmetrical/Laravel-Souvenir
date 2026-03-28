<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Builder\Element;
use App\Models\Builder\Order;
use App\Models\Builder\OrderMessage;
use App\Models\Builder\OrderThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderThreadController extends Controller
{
    // ── GET /track/{code} ─────────────────────────────────────────────────────
public function show(Order $order)
{
    $order->load(['product', 'design', 'items.element', 'user', 'thread']);
 
    // Auto-create thread if it doesn't exist yet (for orders placed before
    // this feature was added)
    $thread = $order->thread ?? OrderThread::firstOrCreate(
        ['order_id' => $order->id],
        ['approval_status' => 'awaiting_mockup']
    );
 
    $messages = OrderMessage::where('order_id', $order->id)
        ->with('user')
        ->oldest()
        ->get();
 
    return view('admin.orders.show', compact('order', 'thread', 'messages'));
}

    // ── POST /orders/{code}/approve ───────────────────────────────────────────
    public function approve(Request $request, string $code)
    {
        $request->validate([
            'body' => 'nullable|string|max:500',
        ]);

        $order  = $this->resolveOrder($code);
        $thread = $order->thread;

        abort_if(! $thread?->canCustomerAct(), 403, 'Approval is not available right now.');

        DB::transaction(function () use ($request, $order, $thread) {
            $thread->update([
                'approval_status' => 'approved',
                'approved_at'     => now(),
            ]);

            $order->update([
                'status'       => 'confirmed',
                'confirmed_at' => now(),
            ]);

            OrderMessage::create([
                'order_id' => $order->id,
                'user_id'  => auth()->id(),
                'type'     => 'approval',
                'body'     => $request->filled('body')
                    ? $request->body
                    : 'I love it! Design approved — please go ahead and make it. ✅',
            ]);
        });

        return back()->with('success', 'Design approved! Your order is confirmed — we\'ll start crafting it soon. 🌸');
    }

    // ── POST /orders/{code}/request-revision ──────────────────────────────────
    // Stores a "note" type message from the customer explaining what to change,
    // then flips the thread status to revision_requested.
    public function requestRevision(Request $request, string $code)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $order  = $this->resolveOrder($code);
        $thread = $order->thread;

        abort_if(! $thread?->canCustomerAct(), 403, 'Revision request not available right now.');

        DB::transaction(function () use ($request, $order, $thread) {
            // Use 'note' type (the schema has no 'revision_request' type)
            OrderMessage::create([
                'order_id' => $order->id,
                'user_id'  => auth()->id(),
                'type'     => 'note',
                'body'     => '🔄 Revision requested: ' . $request->body,
            ]);

            $thread->update(['approval_status' => 'revision_requested']);
        });

        return back()->with('success', 'Revision request sent! We\'ll update the design and send a new mockup. 🌷');
    }

    // ── GET /orders/{code}/revise ─────────────────────────────────────────────
    public function reviseForm(string $code)
    {
        $order  = $this->resolveOrder($code);
        $thread = $order->thread;

        abort_if(! $thread?->canCustomerRevise(), 403, 'Revision is not available at this stage.');

        $product      = $order->product;
        $elements     = $this->getElementsPayload();
        $existingJson = $order->design?->design_json ?? '[]';

        return view('account.orders.revise', compact(
            'order', 'thread', 'product', 'elements', 'existingJson'
        ));
    }

    // ── POST /orders/{code}/revise ────────────────────────────────────────────
    public function revise(Request $request, string $code)
    {
        $request->validate([
            'design'   => 'required|string',
            'snapshot' => 'nullable|string',
            'body'     => 'nullable|string|max:500',
        ]);

        $order  = $this->resolveOrder($code);
        $thread = $order->thread;

        abort_if(! $thread?->canCustomerRevise(), 403);

        DB::transaction(function () use ($request, $order, $thread) {
            $snapshotPath = null;

            if ($raw = $request->snapshot) {
                $binary = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $raw));
                $revNum = $thread->revision_count + 1;
                $path   = "revisions/{$order->order_code}_r{$revNum}.png";
                Storage::disk('public')->put($path, $binary);
                $snapshotPath = $path;
            }

            OrderMessage::create([
                'order_id'      => $order->id,
                'user_id'       => auth()->id(),
                'type'          => 'revision',
                'body'          => $request->filled('body')
                    ? $request->body
                    : 'Here\'s my revised design!',
                'design_json'   => $request->design,   // stored as JSON string
                'snapshot_path' => $snapshotPath,
            ]);

            $thread->increment('revision_count');
            $thread->update(['approval_status' => 'revised']);
        });

        return redirect()
            ->route('account.orders.show', $code)
            ->with('success', 'Revised design submitted! We\'ll send an updated mockup soon. 🔄');
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function resolveOrder(string $code): Order
    {
        $order = Order::where('order_code', $code)
            ->with(['thread', 'product', 'design', 'items'])
            ->firstOrFail();

        $this->authorizeOrder($order);

        return $order;
    }

    private function authorizeOrder(Order $order): void
    {
        if (auth()->check() && $order->user_id && $order->user_id !== auth()->id()) {
            abort(403);
        }
    }

    private function getElementsPayload(): array
    {
        $elements = Element::active()->get();

        return [
            'beads'   => $elements->where('category', 'beads')->map->toCanvasArray()->values(),
            'figures' => $elements->where('category', 'figures')->map->toCanvasArray()->values(),
            'charms'  => $elements->where('category', 'charms')->map->toCanvasArray()->values(),
        ];
    }

    // ── POST /admin/orders/{order}/mockup ─────────────────────────────────────────
// Admin uploads a physical mockup photo → sets approval_status = mockup_sent
public function uploadMockup(Request $request, Order $order)
{
    $request->validate([
        'mockup_photo' => 'required|image|mimes:png,jpg,jpeg,webp|max:8192',
        'note'         => 'nullable|string|max:500',
    ]);
 
    DB::transaction(function () use ($request, $order) {
 
        // Store the photo on the public disk
        $path = $request->file('mockup_photo')
            ->store("mockups/{$order->order_code}", 'public');
 
        // Ensure a thread row exists
        $thread = OrderThread::firstOrCreate(
            ['order_id' => $order->id],
            ['approval_status' => 'awaiting_mockup']
        );
 
        // Create the message — type 'mockup', image_path holds the photo
        OrderMessage::create([
            'order_id'   => $order->id,
            'user_id'    => auth()->id(),          // admin's user ID
            'type'       => 'mockup',
            'body'       => $request->filled('note')
                ? $request->note
                : 'Here\'s your mockup! Please review and let us know what you think. 🌸',
            'image_path' => $path,                 // ← image_path, not mockup_path
        ]);
 
        // Advance the approval state
        $thread->update(['approval_status' => 'mockup_sent']);
    });
 
    return back()->with('success', "Mockup uploaded for {$order->order_code}. Customer can now review.");
}

// ── POST /admin/orders/{order}/note ───────────────────────────────────────────
// Admin sends a plain-text note to the customer thread
public function sendNote(Request $request, Order $order)
{
    $request->validate([
        'body' => 'required|string|max:1000',
    ]);
 
    // Ensure thread exists
    OrderThread::firstOrCreate(
        ['order_id' => $order->id],
        ['approval_status' => 'awaiting_mockup']
    );
 
    OrderMessage::create([
        'order_id' => $order->id,
        'user_id'  => auth()->id(),    // admin's user ID
        'type'     => 'note',
        'body'     => $request->body,
    ]);
 
    return back()->with('success', 'Note sent.');
}
}