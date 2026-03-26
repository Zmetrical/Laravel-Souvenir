<?php

namespace App\Http\Controllers\order;

use App\Http\Controllers\Controller;
use App\Models\builder\Element;
use App\Models\builder\Order;
use App\Models\builder\OrderDesign;
use App\Models\builder\OrderItem;
use App\Models\builder\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    // ── POST /orders ──────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:80',
            'last_name'       => 'required|string|max:80',
            'contact_number'  => 'required|string|max:20',
            'notes'           => 'nullable|string|max:500',
            'product_slug'    => 'required|string|in:bracelet,necklace,keychain',
            'length'          => 'required|string|max:20',
            'design'          => 'required|json',          // JSON.stringify(state.elems)
            'snapshot'        => 'nullable|string',        // base64 PNG from canvas
            // Canvas state
            'str_color'       => 'nullable|string|max:10',
            'str_type'        => 'nullable|string|max:20',
            'clasp'           => 'nullable|string|max:20',
            'view'            => 'nullable|string|max:20',
            'keychain_strands'=> 'nullable|integer|min:1|max:3',
            'ring_type'       => 'nullable|string|max:20',
            'ring_color'      => 'nullable|string|max:10',
            'letter_bg_color' => 'nullable|string|max:10',
            'letter_text_color' => 'nullable|string|max:10',
            'letter_shape'    => 'nullable|string|max:10',
        ]);

        $product = Product::where('slug', $validated['product_slug'])->firstOrFail();
        $elems   = json_decode($validated['design'], true);

        // ── Resolve elements from DB to get live prices ───────────────────────
        $slugs      = collect($elems)->pluck('id')->filter()->unique()->values()->toArray();
        $dbElements = Element::whereIn('slug', $slugs)->get()->keyBy('slug');

        // ── Calculate costs ───────────────────────────────────────────────────
        $elementsCost = collect($elems)->sum(function ($el) use ($dbElements) {
            if (!empty($el['isLetter'])) return 8;   // letters have fixed price
            return $dbElements[$el['id'] ?? '']?->price ?? ($el['price'] ?? 8);
        });

        $totalPrice = $product->base_price + $elementsCost;

        DB::transaction(function () use (
            $validated, $product, $elems,
            $dbElements, $elementsCost, $totalPrice
        ) {
            // ── Create order ──────────────────────────────────────────────────
            $order = Order::create([
                'order_code'     => Order::generateCode(),
                'first_name'     => $validated['first_name'],
                'last_name'      => $validated['last_name'],
                'contact_number' => $validated['contact_number'],
                'notes'          => $validated['notes'] ?? null,
                'product_id'     => $product->id,
                'length'         => $validated['length'],
                'base_price'     => $product->base_price,
                'elements_cost'  => $elementsCost,
                'total_price'    => $totalPrice,
                'status'         => 'pending',
                'user_id'        => auth()->id(),    // null for guests
            ]);

            // ── Store snapshot PNG ────────────────────────────────────────────
            $snapshotPath = null;
            if (!empty($validated['snapshot'])) {
                $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $validated['snapshot']);
                $binary = base64_decode($base64);
                $path   = "designs/{$order->order_code}.png";
                Storage::disk('public')->put($path, $binary);
                $snapshotPath = $path;
            }

            // ── Create design record ──────────────────────────────────────────
            OrderDesign::create([
                'order_id'           => $order->id,
                'design_json'        => $elems,
                'snapshot_path'      => $snapshotPath,
                'str_color'          => $validated['str_color']          ?? null,
                'str_type'           => $validated['str_type']           ?? null,
                'clasp'              => $validated['clasp']              ?? null,
                'view'               => $validated['view']               ?? null,
                'length'             => $validated['length'],
                'keychain_strands'   => $validated['keychain_strands']   ?? 1,
                'ring_type'          => $validated['ring_type']          ?? null,
                'ring_color'         => $validated['ring_color']         ?? null,
                'letter_bg_color'    => $validated['letter_bg_color']    ?? null,
                'letter_text_color'  => $validated['letter_text_color']  ?? null,
                'letter_shape'       => $validated['letter_shape']       ?? null,
            ]);

            // ── Create order items ────────────────────────────────────────────
            $items = [];
            foreach ($elems as $sortIdx => $el) {
                $isLetter  = !empty($el['isLetter']);
                $dbElement = !$isLetter ? ($dbElements[$el['id'] ?? ''] ?? null) : null;

                $items[] = [
                    'order_id'          => $order->id,
                    'element_id'        => $dbElement?->id,
                    'letter'            => $isLetter ? $el['label']   : null,
                    'letter_bg'         => $isLetter ? $el['ltrBg']   : null,
                    'letter_text_color' => $isLetter ? $el['ltrText'] : null,
                    'letter_shape'      => $isLetter ? $el['letterShape'] : null,
                    'strand'            => $el['strand'] ?? 0,
                    'sort_order'        => $sortIdx,
                    'price_at_order'    => $dbElement?->price ?? ($el['price'] ?? 8),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
            }

            OrderItem::insert($items);
        });

        $order = Order::where('order_code', 'like', 'AC-' . now()->format('Ymd') . '-%')
                      ->latest()->first();

        return response()->json([
            'success'    => true,
            'order_code' => $order->order_code,
            'total'      => $order->total_price,
        ]);
    }
}