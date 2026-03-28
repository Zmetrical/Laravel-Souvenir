<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\builder\Order;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
use App\Models\Builder\OrderThread;
use App\Models\Builder\OrderMessage;
class OrderController extends Controller
{
    // ── GET /admin/orders ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Order::with(['product', 'design'])
            ->latest();
 
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
 
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', $search)
                  ->orWhere('first_name', 'like', $search)
                  ->orWhere('last_name',  'like', $search)
                  ->orWhere('contact_number', 'like', $search);
            });
        }
 
        $orders = $query->paginate(20)->withQueryString();
 
        // Counts per status for the tab bar
        $counts = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
 
        return view('admin.orders.index', compact('orders', 'counts'));
    }
 
    // ── GET /admin/orders/{order} ──────────────────────────────────────────
    public function show(Order $order)
    {
        $order->load(['product', 'design', 'items.element', 'user']);
        return view('admin.orders.show', compact('order'));
    }
 
    // ── POST /admin/orders/{order}/status ──────────────────────────────────
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,ready,completed,cancelled',
        ]);
 
        $newStatus = $request->status;
 
        // Guard: completed/cancelled orders cannot be changed
        if (in_array($order->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This order is already ' . $order->status . ' and cannot be changed.');
        }
 
        $timestamps = [];
 
        if ($newStatus === 'confirmed' && ! $order->confirmed_at) {
            $timestamps['confirmed_at'] = now();
        }
        if ($newStatus === 'completed' && ! $order->completed_at) {
            $timestamps['completed_at'] = now();
        }
        if ($newStatus === 'cancelled' && ! $order->cancelled_at) {
            $timestamps['cancelled_at'] = now();
        }
 
        $order->update(array_merge(['status' => $newStatus], $timestamps));
 
        return back()->with('success', 'Order ' . $order->order_code . ' status updated to "' . Order::$statuses[$newStatus] . '".');
    }
 
    // ── GET /admin/orders/{order}/print ────────────────────────────────────
    public function printView(Order $order)
    {
        $order->load(['product', 'design', 'items.element']);
        return view('admin.orders.print', compact('order'));
    }

    // ── POST /admin/orders/{order}/mockup ─────────────────────────────────────────
// Admin uploads a physical mockup photo → sets approval_status to mockup_sent
public function uploadMockup(Request $request, Order $order)
{
    $request->validate([
        'mockup_photo' => 'required|image|mimes:png,jpg,jpeg,webp|max:8192',
        'note'         => 'nullable|string|max:500',
    ]);
 
    DB::transaction(function () use ($request, $order) {
        // Store the photo
        $path = $request->file('mockup_photo')
            ->store("mockups/{$order->order_code}", 'public');
 
        // Ensure thread exists
        $thread = OrderThread::firstOrCreate(
            ['order_id' => $order->id],
            ['approval_status' => 'awaiting_mockup']
        );
 
        // Create the message
        OrderMessage::create([
            'order_id'    => $order->id,
            'sender_type' => 'admin',
            'sender_id'   => auth()->id(),
            'type'        => 'mockup',
            'body'        => $request->filled('note')
                ? $request->note
                : 'Here\'s your mockup! Please review it and let us know what you think.',
            'mockup_path' => $path,
        ]);
 
        // Advance the approval state
        $thread->update(['approval_status' => 'mockup_sent']);
    });
 
    return back()->with('success', "Mockup uploaded for order {$order->order_code}. Customer can now review.");
}
 
// ── POST /admin/orders/{order}/note ───────────────────────────────────────────
// Admin sends a plain-text note to the customer
public function sendNote(Request $request, Order $order)
{
    $request->validate([
        'body' => 'required|string|max:1000',
    ]);
 
    OrderThread::firstOrCreate(
        ['order_id' => $order->id],
        ['approval_status' => 'awaiting_mockup']
    );
 
    OrderMessage::create([
        'order_id'    => $order->id,
        'sender_type' => 'admin',
        'sender_id'   => auth()->id(),
        'type'        => 'note',
        'body'        => $request->body,
    ]);
 
    return back()->with('success', 'Note sent to customer.');
}
 
}