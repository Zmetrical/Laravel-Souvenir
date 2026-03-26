<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_designs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->unique()                      // one design per order
                ->constrained('orders')
                ->cascadeOnDelete();

            // ── Canvas state snapshot (from state.js) ─────────────────────────
            $table->json('design_json');
            // Full JSON.stringify(state.elems) from the frontend
            // Each element: { uid, id, name, shape, color, strand, price, ... }

            $table->string('snapshot_path')->nullable();
            // PNG exported via canvas.toDataURL() → stored via Laravel Storage
            // Path relative to storage/app/public, e.g. designs/AC-20250324-0001.png
            // Serve via: Storage::url($path) or route('designs.show', $order)

            // ── String / cord settings ────────────────────────────────────────
            $table->string('str_color', 10)->nullable();     // hex e.g. #FF5FA0
            $table->string('str_type', 20)->nullable();      // Elastic | Cord | Wire | Chain
            $table->string('clasp', 20)->nullable();         // none | lobster | toggle
            $table->string('view', 20)->nullable();          // silhouette | flatlay
            $table->string('length', 20)->nullable();        // mirrors orders.length for quick access

            // ── Keychain-specific settings ────────────────────────────────────
            $table->tinyInteger('keychain_strands')->default(1);  // 1 | 2 | 3
            $table->string('ring_type', 20)->nullable();
            // ring | heart | carabiner | ballchain
            $table->string('ring_color', 10)->nullable();    // hex

            // ── Letter tile settings ──────────────────────────────────────────
            $table->string('letter_bg_color', 10)->nullable();    // hex
            $table->string('letter_text_color', 10)->nullable();  // hex
            $table->string('letter_shape', 10)->nullable();       // square | round

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_designs');
    }
};