<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_threads', function (Blueprint $table) {
            $table->id();

            // ── One thread per order, always ───────────────────────────────────
            $table->foreignId('order_id')
                  ->unique()
                  ->constrained('orders')
                  ->cascadeOnDelete();

            // ── Approval state machine ─────────────────────────────────────────
            // awaiting_mockup     → order submitted, admin hasn't sent photo yet
            // mockup_sent         → admin uploaded mockup, waiting on customer
            // revision_requested  → customer flagged changes needed
            // revised             → customer submitted new design, admin must re-mockup
            // approved            → customer approved, cleared for production
            // cancelled           → order cancelled at any point
            $table->enum('approval_status', [
                'awaiting_mockup',
                'mockup_sent',
                'revision_requested',
                'revised',
                'approved',
                'cancelled',
            ])->default('awaiting_mockup');

            // ── Revision tracking ──────────────────────────────────────────────
            // Incremented each time the customer submits a revised design.
            // Compared against products.max_revisions to flag overages.
            // Admin is not blocked — this is informational only.
            $table->unsignedTinyInteger('revision_count')->default(0);

            // ── Milestone timestamps ───────────────────────────────────────────
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_threads');
    }
};