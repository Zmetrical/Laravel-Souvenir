<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Grab existing products & elements ──────────────────────────
        // Make sure you've seeded products and elements first.
        // Run: php artisan db:seed --class=SampleOrderSeeder

        $product = DB::table('products')->where('is_active', 1)->first();
        $elements = DB::table('elements')->where('is_active', 1)->get();

        if (! $product) {
            $this->command->warn('No active products found. Creating a sample product...');
            $productId = DB::table('products')->insertGetId([
                'slug'       => 'keychain-standard',
                'label'      => 'Standard Keychain',
                'base_price' => 79,
                'max_beads'  => 20,
                'is_active'  => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $product = DB::table('products')->find($productId);
        }

        // ── 2. Pick up to 8 elements to use as beads ──────────────────────
        // If no elements exist, we'll use letter beads only (no element_id)
        $pickedElements = $elements->take(8);

        // ── 3. Build each sample order ────────────────────────────────────
        $orders = [
            [
                'customer'  => ['first_name' => 'Sofia',   'last_name' => 'Reyes',    'contact' => '09171234567'],
                'status'    => 'pending',
                'length'    => '6 inches',
                'notes'     => 'Please add extra glitter on the charms if possible!',
                'letters'   => ['S', 'O', 'F', 'I', 'A'],
                'letter_bg' => '#FF5FA0',
                'letter_tx' => '#FFFFFF',
                'letter_sh' => 'round',
                'str_color' => '#FF5FA0',
                'str_type'  => 'elastic',
                'clasp'     => 'lobster',
                'ring_type' => 'split',
                'ring_color'=> '#FFD700',
                'strands'   => 1,
                'view'      => 'front',
            ],
            [
                'customer'  => ['first_name' => 'Mia',     'last_name' => 'Santos',   'contact' => '09281112222'],
                'status'    => 'confirmed',
                'length'    => '5 inches',
                'notes'     => null,
                'letters'   => ['M', 'I', 'A'],
                'letter_bg' => '#C4B5FD',
                'letter_tx' => '#4C1D95',
                'letter_sh' => 'square',
                'str_color' => '#1AC8C4',
                'str_type'  => 'cord',
                'clasp'     => 'spring',
                'ring_type' => 'jump',
                'ring_color'=> '#C0C0C0',
                'strands'   => 1,
                'view'      => 'front',
            ],
            [
                'customer'  => ['first_name' => 'Andrea',  'last_name' => 'Cruz',     'contact' => '09393334444'],
                'status'    => 'in_progress',
                'length'    => '7 inches',
                'notes'     => 'Gift for my best friend — please wrap nicely!',
                'letters'   => ['B', 'F', 'F'],
                'letter_bg' => '#FDE68A',
                'letter_tx' => '#92400E',
                'letter_sh' => 'heart',
                'str_color' => '#FF5FA0',
                'str_type'  => 'elastic',
                'clasp'     => 'lobster',
                'ring_type' => 'split',
                'ring_color'=> '#FFD700',
                'strands'   => 2,
                'view'      => 'front',
            ],
            [
                'customer'  => ['first_name' => 'Chloe',   'last_name' => 'Lim',      'contact' => '09505556666'],
                'status'    => 'ready',
                'length'    => '6 inches',
                'notes'     => null,
                'letters'   => ['C', 'H', 'L', 'O', 'E'],
                'letter_bg' => '#BAE6FD',
                'letter_tx' => '#0369A1',
                'letter_sh' => 'round',
                'str_color' => '#93C5FD',
                'str_type'  => 'cord',
                'clasp'     => 'toggle',
                'ring_type' => 'jump',
                'ring_color'=> '#FFD700',
                'strands'   => 1,
                'view'      => 'side',
            ],
            [
                'customer'  => ['first_name' => 'Hannah',  'last_name' => 'Tan',      'contact' => '09617778888'],
                'status'    => 'completed',
                'length'    => '5 inches',
                'notes'     => 'Rush order — needed by Saturday.',
                'letters'   => ['H', 'N', 'H'],
                'letter_bg' => '#D1FAE5',
                'letter_tx' => '#065F46',
                'letter_sh' => 'square',
                'str_color' => '#6EE7B7',
                'str_type'  => 'elastic',
                'clasp'     => 'lobster',
                'ring_type' => 'split',
                'ring_color'=> '#C0C0C0',
                'strands'   => 1,
                'view'      => 'front',
            ],
            [
                'customer'  => ['first_name' => 'Bianca',  'last_name' => 'Flores',   'contact' => '09729990000'],
                'status'    => 'cancelled',
                'length'    => '6 inches',
                'notes'     => 'Changed my mind, sorry!',
                'letters'   => ['B', 'I'],
                'letter_bg' => '#FEE2E2',
                'letter_tx' => '#991B1B',
                'letter_sh' => 'round',
                'str_color' => '#FCA5A5',
                'str_type'  => 'cord',
                'clasp'     => 'spring',
                'ring_type' => 'jump',
                'ring_color'=> '#FFD700',
                'strands'   => 1,
                'view'      => 'front',
            ],
        ];

        foreach ($orders as $i => $data) {

            // ── Generate order code ────────────────────────────────────────
            $date      = now()->subDays(count($orders) - $i)->format('Ymd');
            $orderCode = sprintf('AC-%s-%04d', $date, $i + 1);

            // ── Compute pricing ────────────────────────────────────────────
            $basePrice     = $product->base_price;
            $letterPrice   = 8;  // ₱8 per letter bead
            $elementCount  = min($pickedElements->count(), 5);
            $lettersCount  = count($data['letters']);
            $elementsCost  = ($pickedElements->take($elementCount)->sum('price') ?: $elementCount * 8)
                           + ($lettersCount * $letterPrice);
            $totalPrice    = $basePrice + $elementsCost;

            // ── Timestamps ────────────────────────────────────────────────
            $createdAt   = now()->subDays(count($orders) - $i);
            $confirmedAt = in_array($data['status'], ['confirmed','in_progress','ready','completed'])
                ? $createdAt->copy()->addHours(2) : null;
            $completedAt = $data['status'] === 'completed'
                ? $createdAt->copy()->addDays(2) : null;
            $cancelledAt = $data['status'] === 'cancelled'
                ? $createdAt->copy()->addHours(5) : null;

            // ── Insert order ───────────────────────────────────────────────
            $orderId = DB::table('orders')->insertGetId([
                'order_code'     => $orderCode,
                'first_name'     => $data['customer']['first_name'],
                'last_name'      => $data['customer']['last_name'],
                'contact_number' => $data['customer']['contact'],
                'notes'          => $data['notes'],
                'product_id'     => $product->id,
                'length'         => $data['length'],
                'base_price'     => $basePrice,
                'elements_cost'  => $elementsCost,
                'total_price'    => $totalPrice,
                'status'         => $data['status'],
                'confirmed_at'   => $confirmedAt,
                'completed_at'   => $completedAt,
                'cancelled_at'   => $cancelledAt,
                'user_id'        => null,
                'created_at'     => $createdAt,
                'updated_at'     => $createdAt,
            ]);

            // ── Build design_json ──────────────────────────────────────────
            // This is a simplified Fabric.js-style object array
            // representing beads + letter charms on the canvas
            $canvasObjects = [];
            $xPos = 40;

            // Add element beads to canvas objects
            foreach ($pickedElements->take($elementCount) as $el) {
                $canvasObjects[] = [
                    'type'      => 'bead',
                    'elementId' => $el->id,
                    'slug'      => $el->slug,
                    'shape'     => $el->shape ?? 'round',
                    'color'     => $el->color ?? '#F9B8CF',
                    'detail'    => $el->detail_color ?? '#C0136A',
                    'left'      => $xPos,
                    'top'       => 100,
                    'scaleX'    => 1,
                    'scaleY'    => 1,
                ];
                $xPos += 44;
            }

            // Add letter beads
            foreach ($data['letters'] as $letter) {
                $canvasObjects[] = [
                    'type'    => 'letter',
                    'letter'  => $letter,
                    'bg'      => $data['letter_bg'],
                    'color'   => $data['letter_tx'],
                    'shape'   => $data['letter_sh'],
                    'left'    => $xPos,
                    'top'     => 100,
                    'scaleX'  => 1,
                    'scaleY'  => 1,
                ];
                $xPos += 40;
            }

            $designJson = [
                'version'  => '5.3.0',
                'objects'  => $canvasObjects,
                'background' => '',
            ];

            // ── Insert order_design ────────────────────────────────────────
            DB::table('order_designs')->insert([
                'order_id'          => $orderId,
                'design_json'       => json_encode($designJson),
                'snapshot_path'     => null,          // no actual image file in seeder
                'str_color'         => $data['str_color'],
                'str_type'          => $data['str_type'],
                'clasp'             => $data['clasp'],
                'view'              => $data['view'],
                'length'            => $data['length'],
                'keychain_strands'  => $data['strands'],
                'ring_type'         => $data['ring_type'],
                'ring_color'        => $data['ring_color'],
                'letter_bg_color'   => $data['letter_bg'],
                'letter_text_color' => $data['letter_tx'],
                'letter_shape'      => $data['letter_sh'],
                'created_at'        => $createdAt,
                'updated_at'        => $createdAt,
            ]);

            // ── Insert order_items ─────────────────────────────────────────
            $sortOrder = 0;

            // Element beads (strand 0)
            foreach ($pickedElements->take($elementCount) as $el) {
                DB::table('order_items')->insert([
                    'order_id'       => $orderId,
                    'element_id'     => $el->id,
                    'letter'         => null,
                    'letter_bg'      => null,
                    'letter_text_color' => null,
                    'letter_shape'   => null,
                    'strand'         => 0,
                    'sort_order'     => $sortOrder++,
                    'price_at_order' => $el->price ?? 8,
                    'created_at'     => $createdAt,
                    'updated_at'     => $createdAt,
                ]);
            }

            // Letter beads — spread across strands if multi-strand
            foreach ($data['letters'] as $j => $letter) {
                $strand = ($data['strands'] > 1) ? ($j % $data['strands']) : 0;

                DB::table('order_items')->insert([
                    'order_id'          => $orderId,
                    'element_id'        => null,
                    'letter'            => $letter,
                    'letter_bg'         => $data['letter_bg'],
                    'letter_text_color' => $data['letter_tx'],
                    'letter_shape'      => $data['letter_sh'],
                    'strand'            => $strand,
                    'sort_order'        => $sortOrder++,
                    'price_at_order'    => $letterPrice,
                    'created_at'        => $createdAt,
                    'updated_at'        => $createdAt,
                ]);
            }

            $this->command->info("✅ Created order {$orderCode} ({$data['status']}) for {$data['customer']['first_name']} {$data['customer']['last_name']}");
        }

        $this->command->newLine();
    }
}