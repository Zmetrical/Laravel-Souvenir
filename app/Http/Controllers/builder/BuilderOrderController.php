<?php

namespace App\Http\Controllers\builder;

use App\Http\Controllers\Controller;
use App\Models\builder\Element;
use App\Models\builder\Order;
use App\Models\builder\OrderDesign;
use App\Models\builder\OrderItem;
use App\Models\builder\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\builder\OrderThread;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BuilderOrderController extends Controller
{
    // ── STEP 1: JS posts design state here ────────────────────────────────────
    // Stores everything in session, redirects to the order form page
    public function preview(Request $request)
    {
        $request->validate([
            'design'      => 'required|string',
            'product_slug'=> 'required|in:bracelet,necklace,keychain',
            'snapshot'    => 'nullable|string',
        ]);

        session([
            'order_design'        => $request->design,
            'order_snapshot'      => $request->snapshot,
            'order_product_slug'  => $request->product_slug,
            'order_length'        => $request->length,
            'order_str_color'     => $request->str_color,
            'order_str_type'      => $request->str_type,
            'order_clasp'         => $request->clasp,
            'order_view'          => $request->view,
            'order_strands'       => $request->keychain_strands ?? 1,
            'order_ring_type'     => $request->ring_type,
            'order_ring_color'    => $request->ring_color,
            'order_ltr_bg'        => $request->letter_bg_color,
            'order_ltr_text'      => $request->letter_text_color,
            'order_ltr_shape'     => $request->letter_shape,
        ]);

        return redirect()->route('builder.order.create');
    }

    // ── STEP 2: Show the order form page ──────────────────────────────────────
    public function create()
    {
        if (! session()->has('order_product_slug')) {
            return redirect()->route('builder.bracelet')
                ->with('toast', 'Please design something first!');
        }

        $slug    = session('order_product_slug');
        $product = Product::where('slug', $slug)->firstOrFail();
        $elems   = json_decode(session('order_design', '[]'), true) ?? [];

        $elementsCost = collect($elems)->sum(fn($e) => $e['price'] ?? 8);
        $total        = $product->base_price + $elementsCost;

        return view('order.create', compact('product', 'elems', 'elementsCost', 'total'));
    }

    // ── STEP 3: Submit the form → save to DB ──────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:80',
            'last_name'      => 'required|string|max:80',
            'contact_number' => 'required|string|max:20',
            'notes'          => 'nullable|string|max:500',
        ]);

        // Pull design data from session
        $slug    = session('order_product_slug');
        $product = Product::where('slug', $slug)->firstOrFail();
        $elems   = json_decode(session('order_design', '[]'), true) ?? [];

        $slugs      = collect($elems)->pluck('id')->filter()->unique()->toArray();
        $dbElements = Element::whereIn('slug', $slugs)->get()->keyBy('slug');

        $elementsCost = collect($elems)->sum(function ($el) use ($dbElements) {
            if (! empty($el['isLetter'])) return 8;
            return $dbElements[$el['id'] ?? '']?->price ?? ($el['price'] ?? 8);
        });

        $totalPrice = $product->base_price + $elementsCost;
        $order      = null;

        DB::transaction(function () use (
            $validated, $product, $elems,
            $dbElements, $elementsCost, $totalPrice, &$order
        ) {
            $order = Order::create([
                'order_code'     => Order::generateCode(),
                'first_name'     => $validated['first_name'],
                'last_name'      => $validated['last_name'],
                'contact_number' => $validated['contact_number'],
                'notes'          => $validated['notes'] ?? null,
                'product_id'     => $product->id,
                'length'         => session('order_length'),
                'base_price'     => $product->base_price,
                'elements_cost'  => $elementsCost,
                'total_price'    => $totalPrice,
                'status'         => 'pending',
                'user_id'        => auth()->id()?? 1,
            ]);
            OrderThread::create([
                'order_id'        => $order->id,
                'approval_status' => 'awaiting_mockup',
            ]);
            $snapshotPath = null;
            if ($raw = session('order_snapshot')) {
                $binary = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $raw));
                $path   = "designs/{$order->order_code}.png";
                Storage::disk('public')->put($path, $binary);
                $snapshotPath = $path;
            }

            OrderDesign::create([
                'order_id'          => $order->id,
                'design_json'       => session('order_design'),
                'snapshot_path'     => $snapshotPath,
                'str_color'         => session('order_str_color'),
                'str_type'          => session('order_str_type'),
                'clasp'             => session('order_clasp'),
                'view'              => session('order_view'),
                'length'            => session('order_length'),
                'keychain_strands'  => session('order_strands', 1),
                'ring_type'         => session('order_ring_type'),
                'ring_color'        => session('order_ring_color'),
                'letter_bg_color'   => session('order_ltr_bg'),
                'letter_text_color' => session('order_ltr_text'),
                'letter_shape'      => session('order_ltr_shape'),
            ]);

            $items = [];
            foreach ($elems as $idx => $el) {
                $isLetter  = ! empty($el['isLetter']);
                $dbElement = ! $isLetter ? ($dbElements[$el['id'] ?? ''] ?? null) : null;
                $items[]   = [
                    'order_id'          => $order->id,
                    'element_id'        => $dbElement?->id,
                    'letter'            => $isLetter ? ($el['label']      ?? null) : null,
                    'letter_bg'         => $isLetter ? ($el['ltrBg']      ?? null) : null,
                    'letter_text_color' => $isLetter ? ($el['ltrText']    ?? null) : null,
                    'letter_shape'      => $isLetter ? ($el['letterShape'] ?? null) : null,
                    'strand'            => $el['strand']  ?? 0,
                    'sort_order'        => $idx,
                    'price_at_order'    => $dbElement?->price ?? ($el['price'] ?? 8),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }

            OrderItem::insert($items);
        });

        // Clear session
        session()->forget([
            'order_design', 'order_snapshot', 'order_product_slug',
            'order_length', 'order_str_color', 'order_str_type', 'order_clasp',
            'order_view', 'order_strands', 'order_ring_type', 'order_ring_color',
            'order_ltr_bg', 'order_ltr_text', 'order_ltr_shape',
        ]);

        return redirect()->route('builder.order.confirmation', $order->order_code);
    }

    // ── STEP 4: Confirmation page ─────────────────────────────────────────────
    public function confirmation(string $code)
    {
        $order = Order::with('design')->where('order_code', $code)->firstOrFail();
        return view('order.confirmation', compact('order'));
    }

    // ── Status check ──────────────────────────────────────────────────────────
    public function status(string $code)
    {
        $order = Order::with('design')->where('order_code', $code)->firstOrFail();
        return view('order.status', compact('order'));
    }
}