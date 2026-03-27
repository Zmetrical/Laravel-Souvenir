<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('elements', function (Blueprint $table) {
            // Drop the foreign key first (if it exists), then the column
            if (Schema::hasColumn('elements', 'series_id')) {
                try {
                    $table->dropForeign(['series_id']);
                } catch (\Exception $e) {
                    // No FK constraint existed — safe to continue
                }
                $table->dropColumn('series_id');
            }
        });

        Schema::dropIfExists('element_series');
    }

    public function down(): void
    {
        // Recreate element_series
        Schema::create('element_series', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Restore series_id column on elements
        Schema::table('elements', function (Blueprint $table) {
            $table->foreignId('series_id')
                  ->nullable()
                  ->after('img_path')
                  ->constrained('element_series')
                  ->nullOnDelete();
        });
    }
};