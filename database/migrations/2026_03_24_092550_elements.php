<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elements', function (Blueprint $table) {
            $table->id();

            // ── Identity ──────────────────────────────────────────────────────
            $table->string('slug')->unique();
            // Matches your JS ids: b1, e1, t1, p1, f1, sd1, cb1, dc1, fg1, bts1
            // Used to look up elements when processing order_items from design JSON

            $table->string('name');                   // Round Blush | Cube Mint | Hello Kitty 1

            // ── Categorization ────────────────────────────────────────────────
            $table->enum('category', [
                'beads',      // round, ellipse, tube, pearl, faceted, seed
                'figures',    // cube variants
                'charms',     // image-based characters
                'letters',    // A–Z, 0–9 (optional, if you want to track letter usage)
            ]);

            $table->string('group')->nullable();
            // Beads:   Round | Oval | Tube | Pearl | Gem | Seed
            // Figures: Plain Cubes | Dice Cubes | Heart Cubes | Star Cubes | Checker Cubes | Smiley Cubes
            // Charms:  null (grouped by series instead)

            // ── Canvas Shape ──────────────────────────────────────────────────
            $table->string('shape')->nullable();
            // round | ellipse | tube | pearl | faceted | heart | star | moon |
            // flower | rainbow | bow | butterfly |
            // cube | cube-dice1..6 | cube-heart | cube-star | cube-checker | cube-smile

            // ── Colors ────────────────────────────────────────────────────────
            $table->string('color', 10)->nullable();         // primary hex  e.g. #F9B8CF
            $table->string('detail_color', 10)->nullable();  // accent hex   e.g. #C0136A (dice dots, cube prints)

            // ── Image-based charms ────────────────────────────────────────────
            $table->boolean('use_img')->default(false);      // true for charms
            $table->string('img_path')->nullable();
            // Storage path, e.g. elements/charms/hello-kitty/01.png
            // Serve via Storage::url() or asset()

            $table->foreignId('series_id')
                ->nullable()
                ->constrained('element_series')
                ->nullOnDelete();
            // Only set for charms: Hello Kitty → series_id = 1

            // ── Size flags ────────────────────────────────────────────────────
            $table->boolean('is_small')->default(false);     // seed beads  (radius 14px)
            $table->boolean('is_large')->default(false);     // charm figures (radius 28px)

            // ── Pricing & stock ───────────────────────────────────────────────
            $table->unsignedInteger('price')->default(8);    // ₱ per piece
            $table->enum('stock', ['in', 'low', 'out'])->default('in');

            // ── Soft toggle ───────────────────────────────────────────────────
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elements');
    }
};