<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // ── Order identity ────────────────────────────────────────────────
            $table->string('order_code')->unique();
            // Format: AC-YYYYMMDD-XXXX  e.g. AC-20250324-0001
            // Generate in OrderService or model boot

            // ── Customer info (from modal-order form) ─────────────────────────
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact_number', 20);
            $table->text('notes')->nullable();

            // ── Product reference ─────────────────────────────────────────────
            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();
            // bracelet | necklace | keychain

            // ── Size / length selection ───────────────────────────────────────
            $table->string('length');
            // Bracelet:  small=16cm | medium=18cm | large=20cm | custom
            // Necklace:  small=40cm | medium=45cm | large=50cm | custom
            // Keychain:  small=8cm  | medium=12cm | large=16cm | custom

            // ── Pricing snapshot ──────────────────────────────────────────────
            $table->unsignedInteger('base_price');      // product base price at time of order
            $table->unsignedInteger('elements_cost');   // sum of all order_items prices
            $table->unsignedInteger('total_price');     // base_price + elements_cost

            // ── Order lifecycle (Phase 3 admin dashboard) ─────────────────────
            $table->enum('status', [
                'pending',      // just submitted, awaiting review
                'confirmed',    // admin confirmed, payment verified
                'in_progress',  // being crafted
                'ready',        // ready for pickup / shipping
                'completed',    // done
                'cancelled',    // cancelled by customer or admin
            ])->default('pending');

            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            // ── Optional: link to auth user (Phase 2 accounts) ───────────────
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            // null = guest order (no account required initially)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};