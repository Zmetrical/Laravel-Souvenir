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

            // ── Order identity ─────────────────────────────────────────────────
            // Format: AC-YYYYMMDD-XXXX  e.g. AC-20250324-0001
            $table->string('order_code')->unique();

            // ── Customer info (from modal-order form) ──────────────────────────
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact_number', 20);
            $table->text('notes')->nullable();

            // ── Product reference ──────────────────────────────────────────────
            // bracelet | necklace | keychain
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->restrictOnDelete();

            // ── Size / length selection ────────────────────────────────────────
            // Bracelet:  small=16cm | medium=18cm | large=20cm | custom
            // Necklace:  small=40cm | medium=45cm | large=50cm | custom
            // Keychain:  small=8cm  | medium=12cm | large=16cm | custom
            $table->string('length');

            // ── Pricing snapshot ───────────────────────────────────────────────
            $table->unsignedInteger('base_price');    // product base at time of order
            $table->unsignedInteger('elements_cost'); // sum of all order_items prices
            $table->unsignedInteger('total_price');   // base_price + elements_cost

            // ── Order lifecycle ────────────────────────────────────────────────
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

            // ── Auth user — required (guests cannot order) ─────────────────────
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete();
            // restrictOnDelete: prevents accidentally deleting a user
            // who still has open orders. Deactivate the user instead.

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};