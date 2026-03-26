<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'slug'       => 'bracelet',
                'label'      => 'Bracelet',
                'base_price' => 80,
                'max_beads'  => 20,
                'is_active'  => true,
            ],
            [
                'slug'       => 'necklace',
                'label'      => 'Necklace',
                'base_price' => 100,
                'max_beads'  => 28,
                'is_active'  => true,
            ],
            [
                'slug'       => 'keychain',
                'label'      => 'Keychain',
                'base_price' => 65,
                'max_beads'  => 12,
                'is_active'  => true,
            ],
        ];

        DB::table('products')->insertOrIgnore($products);
    }
}