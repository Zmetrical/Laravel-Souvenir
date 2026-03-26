<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // ── Element reference ─────────────────────────────────────────────
            $table->foreignId('element_id')
                ->nullable()
                ->constrained('elements')
                ->nullOnDelete();
            // null when item is a letter tile (no catalog element)

            // ── Letter tile fields (only when element_id is null) ─────────────
            $table->char('letter', 1)->nullable();           // A-Z | 0-9
            $table->string('letter_bg', 10)->nullable();     // hex background
            $table->string('letter_text_color', 10)->nullable(); // hex text
            $table->string('letter_shape', 10)->nullable();  // square | round

            // ── Keychain strand placement ─────────────────────────────────────
            $table->tinyInteger('strand')->default(0);
            // 0 = first strand (or non-keychain products)
            // 1 = second strand
            // 2 = third strand

            // ── Position in design ────────────────────────────────────────────
            $table->unsignedSmallInteger('sort_order');
            // Index from state.elems array — preserves left-to-right order on canvas

            // ── Price snapshot ────────────────────────────────────────────────
            $table->unsignedInteger('price_at_order');
            // Captured at submission time — protects against future price changes

            $table->timestamps();

            // ── Indexes ───────────────────────────────────────────────────────
            $table->index(['order_id', 'sort_order']);
            $table->index(['order_id', 'strand']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};