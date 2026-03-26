<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElementSeeder extends Seeder
{
    public function run(): void
    {
        // ── Series ────────────────────────────────────────────────────────────
        DB::table('element_series')->insertOrIgnore([
            ['name' => 'Hello Kitty', 'slug' => 'hello-kitty', 'is_active' => true],
            ['name' => 'BTS',         'slug' => 'bts',         'is_active' => true],
        ]);

        $hkId  = DB::table('element_series')->where('slug', 'hello-kitty')->value('id');
        $btsId = DB::table('element_series')->where('slug', 'bts')->value('id');

        // ── Beads ─────────────────────────────────────────────────────────────
        $beads = [
            // Round
            ['slug'=>'b1',  'name'=>'Round Blush',    'category'=>'beads', 'group'=>'Round',  'shape'=>'round',   'color'=>'#F9B8CF', 'price'=>8],
            ['slug'=>'b2',  'name'=>'Round Mint',     'category'=>'beads', 'group'=>'Round',  'shape'=>'round',   'color'=>'#90DDD9', 'price'=>8],
            ['slug'=>'b3',  'name'=>'Round Lavender', 'category'=>'beads', 'group'=>'Round',  'shape'=>'round',   'color'=>'#C9A9F0', 'price'=>8],
            ['slug'=>'b4',  'name'=>'Round Butter',   'category'=>'beads', 'group'=>'Round',  'shape'=>'round',   'color'=>'#FFE07A', 'price'=>8],
            ['slug'=>'b5',  'name'=>'Round Sky',      'category'=>'beads', 'group'=>'Round',  'shape'=>'round',   'color'=>'#9DD4F7', 'price'=>8],
            ['slug'=>'b6',  'name'=>'Round Peach',    'category'=>'beads', 'group'=>'Round',  'shape'=>'round',   'color'=>'#FFBEA0', 'price'=>8],
            ['slug'=>'b7',  'name'=>'Round Lime',     'category'=>'beads', 'group'=>'Round',  'shape'=>'round',   'color'=>'#BFED82', 'price'=>8,  'stock'=>'low'],
            ['slug'=>'b8',  'name'=>'Round White',    'category'=>'beads', 'group'=>'Round',  'shape'=>'round',   'color'=>'#F5F5FF', 'price'=>7],
            ['slug'=>'b9',  'name'=>'Round Ink',      'category'=>'beads', 'group'=>'Round',  'shape'=>'round',   'color'=>'#3D3D52', 'price'=>7],
            // Oval
            ['slug'=>'e1',  'name'=>'Oval Blush',     'category'=>'beads', 'group'=>'Oval',   'shape'=>'ellipse', 'color'=>'#F9B8CF', 'price'=>9],
            ['slug'=>'e2',  'name'=>'Oval Mint',      'category'=>'beads', 'group'=>'Oval',   'shape'=>'ellipse', 'color'=>'#90DDD9', 'price'=>9],
            ['slug'=>'e3',  'name'=>'Oval Lavender',  'category'=>'beads', 'group'=>'Oval',   'shape'=>'ellipse', 'color'=>'#C9A9F0', 'price'=>9],
            ['slug'=>'e4',  'name'=>'Oval Butter',    'category'=>'beads', 'group'=>'Oval',   'shape'=>'ellipse', 'color'=>'#FFE07A', 'price'=>9],
            ['slug'=>'e5',  'name'=>'Oval Sky',       'category'=>'beads', 'group'=>'Oval',   'shape'=>'ellipse', 'color'=>'#9DD4F7', 'price'=>9],
            ['slug'=>'e6',  'name'=>'Oval Peach',     'category'=>'beads', 'group'=>'Oval',   'shape'=>'ellipse', 'color'=>'#FFBEA0', 'price'=>9],
            ['slug'=>'e7',  'name'=>'Oval Lime',      'category'=>'beads', 'group'=>'Oval',   'shape'=>'ellipse', 'color'=>'#BFED82', 'price'=>9,  'stock'=>'low'],
            ['slug'=>'e8',  'name'=>'Oval White',     'category'=>'beads', 'group'=>'Oval',   'shape'=>'ellipse', 'color'=>'#F5F5FF', 'price'=>8],
            // Tube
            ['slug'=>'t1',  'name'=>'Tube Blush',     'category'=>'beads', 'group'=>'Tube',   'shape'=>'tube',    'color'=>'#F9B8CF', 'price'=>8],
            ['slug'=>'t2',  'name'=>'Tube Mint',      'category'=>'beads', 'group'=>'Tube',   'shape'=>'tube',    'color'=>'#90DDD9', 'price'=>8],
            ['slug'=>'t3',  'name'=>'Tube Lavender',  'category'=>'beads', 'group'=>'Tube',   'shape'=>'tube',    'color'=>'#C9A9F0', 'price'=>8],
            ['slug'=>'t4',  'name'=>'Tube Butter',    'category'=>'beads', 'group'=>'Tube',   'shape'=>'tube',    'color'=>'#FFE07A', 'price'=>8],
            ['slug'=>'t5',  'name'=>'Tube Peach',     'category'=>'beads', 'group'=>'Tube',   'shape'=>'tube',    'color'=>'#FFBEA0', 'price'=>8],
            // Pearl
            ['slug'=>'p1',  'name'=>'Pearl White',    'category'=>'beads', 'group'=>'Pearl',  'shape'=>'pearl',   'color'=>'#FDF8F0', 'price'=>12],
            ['slug'=>'p2',  'name'=>'Pearl Blush',    'category'=>'beads', 'group'=>'Pearl',  'shape'=>'pearl',   'color'=>'#FFE4EE', 'price'=>12],
            ['slug'=>'p3',  'name'=>'Pearl Lavender', 'category'=>'beads', 'group'=>'Pearl',  'shape'=>'pearl',   'color'=>'#EDE4FF', 'price'=>12],
            ['slug'=>'p4',  'name'=>'Pearl Mint',     'category'=>'beads', 'group'=>'Pearl',  'shape'=>'pearl',   'color'=>'#DAFAF8', 'price'=>12],
            // Gem / Faceted
            ['slug'=>'f1',  'name'=>'Gem Blue',       'category'=>'beads', 'group'=>'Gem',    'shape'=>'faceted', 'color'=>'#8EC5FC', 'detail_color'=>'#6EB0FF', 'price'=>10],
            ['slug'=>'f2',  'name'=>'Gem Rose',       'category'=>'beads', 'group'=>'Gem',    'shape'=>'faceted', 'color'=>'#FFB3C6', 'detail_color'=>'#FF8FAD', 'price'=>10, 'stock'=>'low'],
            ['slug'=>'f3',  'name'=>'Gem Amber',      'category'=>'beads', 'group'=>'Gem',    'shape'=>'faceted', 'color'=>'#FFD780', 'detail_color'=>'#FFC040', 'price'=>10],
            ['slug'=>'f4',  'name'=>'Gem Mint',       'category'=>'beads', 'group'=>'Gem',    'shape'=>'faceted', 'color'=>'#90DDD9', 'detail_color'=>'#60C8C4', 'price'=>10],
            ['slug'=>'f5',  'name'=>'Gem Lilac',      'category'=>'beads', 'group'=>'Gem',    'shape'=>'faceted', 'color'=>'#C9A9F0', 'detail_color'=>'#A07EE0', 'price'=>10],
            // Seed (small)
            ['slug'=>'sd1', 'name'=>'Seed Blush',     'category'=>'beads', 'group'=>'Seed',   'shape'=>'round',   'color'=>'#F9B8CF', 'price'=>4, 'is_small'=>true],
            ['slug'=>'sd2', 'name'=>'Seed Mint',      'category'=>'beads', 'group'=>'Seed',   'shape'=>'round',   'color'=>'#90DDD9', 'price'=>4, 'is_small'=>true],
            ['slug'=>'sd3', 'name'=>'Seed Lavender',  'category'=>'beads', 'group'=>'Seed',   'shape'=>'round',   'color'=>'#C9A9F0', 'price'=>4, 'is_small'=>true],
            ['slug'=>'sd4', 'name'=>'Seed Butter',    'category'=>'beads', 'group'=>'Seed',   'shape'=>'round',   'color'=>'#FFE07A', 'price'=>4, 'is_small'=>true],
            ['slug'=>'sd5', 'name'=>'Seed Peach',     'category'=>'beads', 'group'=>'Seed',   'shape'=>'round',   'color'=>'#FFBEA0', 'price'=>4, 'is_small'=>true],
            ['slug'=>'sd6', 'name'=>'Seed White',     'category'=>'beads', 'group'=>'Seed',   'shape'=>'round',   'color'=>'#F5F5FF', 'price'=>4, 'is_small'=>true],
            ['slug'=>'sd7', 'name'=>'Seed Sky',       'category'=>'beads', 'group'=>'Seed',   'shape'=>'round',   'color'=>'#9DD4F7', 'price'=>4, 'is_small'=>true],
        ];

        // ── Figures ───────────────────────────────────────────────────────────
        $figures = [
            // Plain Cubes
            ['slug'=>'cb1',  'name'=>'Cube Blush',          'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#F9B8CF', 'price'=>10],
            ['slug'=>'cb2',  'name'=>'Cube Mint',           'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#90DDD9', 'price'=>10],
            ['slug'=>'cb3',  'name'=>'Cube Lavender',       'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#C9A9F0', 'price'=>10],
            ['slug'=>'cb4',  'name'=>'Cube Butter',         'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#FFE07A', 'price'=>10],
            ['slug'=>'cb5',  'name'=>'Cube Sky',            'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#9DD4F7', 'price'=>10],
            ['slug'=>'cb6',  'name'=>'Cube Peach',          'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#FFBEA0', 'price'=>10],
            ['slug'=>'cb7',  'name'=>'Cube Lime',           'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#BFED82', 'price'=>10],
            ['slug'=>'cb8',  'name'=>'Cube White',          'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#F5F5FF', 'price'=>9],
            ['slug'=>'cb9',  'name'=>'Cube Ink',            'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#3D3D52', 'price'=>9],
            ['slug'=>'cb10', 'name'=>'Cube Red',            'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#FF8FAD', 'price'=>10],
            ['slug'=>'cb11', 'name'=>'Cube Purple',         'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#A855F7', 'price'=>10, 'stock'=>'low'],
            ['slug'=>'cb12', 'name'=>'Cube Coral',          'category'=>'figures', 'group'=>'Plain Cubes',   'shape'=>'cube',         'color'=>'#FF6B6B', 'price'=>10],
            // Dice Cubes
            ['slug'=>'dc1',  'name'=>'Dice 1 Pink',         'category'=>'figures', 'group'=>'Dice Cubes',    'shape'=>'cube-dice1',   'color'=>'#F9B8CF', 'detail_color'=>'#C0136A', 'price'=>12],
            ['slug'=>'dc2',  'name'=>'Dice 2 Mint',         'category'=>'figures', 'group'=>'Dice Cubes',    'shape'=>'cube-dice2',   'color'=>'#90DDD9', 'detail_color'=>'#0A9690', 'price'=>12],
            ['slug'=>'dc3',  'name'=>'Dice 3 Lavender',     'category'=>'figures', 'group'=>'Dice Cubes',    'shape'=>'cube-dice3',   'color'=>'#C9A9F0', 'detail_color'=>'#5E35C8', 'price'=>12],
            ['slug'=>'dc4',  'name'=>'Dice 4 Butter',       'category'=>'figures', 'group'=>'Dice Cubes',    'shape'=>'cube-dice4',   'color'=>'#FFE07A', 'detail_color'=>'#A07200', 'price'=>12],
            ['slug'=>'dc5',  'name'=>'Dice 5 Sky',          'category'=>'figures', 'group'=>'Dice Cubes',    'shape'=>'cube-dice5',   'color'=>'#9DD4F7', 'detail_color'=>'#2563EB', 'price'=>12],
            ['slug'=>'dc6',  'name'=>'Dice 6 Peach',        'category'=>'figures', 'group'=>'Dice Cubes',    'shape'=>'cube-dice6',   'color'=>'#FFBEA0', 'detail_color'=>'#C05020', 'price'=>12],
            ['slug'=>'dc7',  'name'=>'Dice 1 White',        'category'=>'figures', 'group'=>'Dice Cubes',    'shape'=>'cube-dice1',   'color'=>'#F5F5FF', 'detail_color'=>'#3D3D52', 'price'=>12],
            ['slug'=>'dc8',  'name'=>'Dice 6 Black',        'category'=>'figures', 'group'=>'Dice Cubes',    'shape'=>'cube-dice6',   'color'=>'#3D3D52', 'detail_color'=>'#F5F5FF', 'price'=>12],
            // Heart Cubes
            ['slug'=>'hc1',  'name'=>'Heart Cube Blush',    'category'=>'figures', 'group'=>'Heart Cubes',   'shape'=>'cube-heart',   'color'=>'#F9B8CF', 'detail_color'=>'#C0136A', 'price'=>13],
            ['slug'=>'hc2',  'name'=>'Heart Cube Mint',     'category'=>'figures', 'group'=>'Heart Cubes',   'shape'=>'cube-heart',   'color'=>'#90DDD9', 'detail_color'=>'#FF5FA0', 'price'=>13],
            ['slug'=>'hc3',  'name'=>'Heart Cube Lavender', 'category'=>'figures', 'group'=>'Heart Cubes',   'shape'=>'cube-heart',   'color'=>'#C9A9F0', 'detail_color'=>'#FFE07A', 'price'=>13],
            ['slug'=>'hc4',  'name'=>'Heart Cube White',    'category'=>'figures', 'group'=>'Heart Cubes',   'shape'=>'cube-heart',   'color'=>'#F5F5FF', 'detail_color'=>'#FF8FAD', 'price'=>13],
            ['slug'=>'hc5',  'name'=>'Heart Cube Black',    'category'=>'figures', 'group'=>'Heart Cubes',   'shape'=>'cube-heart',   'color'=>'#3D3D52', 'detail_color'=>'#F9B8CF', 'price'=>13, 'stock'=>'low'],
            // Star Cubes
            ['slug'=>'sc1',  'name'=>'Star Cube Gold',      'category'=>'figures', 'group'=>'Star Cubes',    'shape'=>'cube-star',    'color'=>'#FFE07A', 'detail_color'=>'#C0136A', 'price'=>13],
            ['slug'=>'sc2',  'name'=>'Star Cube Pink',      'category'=>'figures', 'group'=>'Star Cubes',    'shape'=>'cube-star',    'color'=>'#F9B8CF', 'detail_color'=>'#FFD700', 'price'=>13],
            ['slug'=>'sc3',  'name'=>'Star Cube Mint',      'category'=>'figures', 'group'=>'Star Cubes',    'shape'=>'cube-star',    'color'=>'#90DDD9', 'detail_color'=>'#FFFFFF', 'price'=>13],
            ['slug'=>'sc4',  'name'=>'Star Cube Lavender',  'category'=>'figures', 'group'=>'Star Cubes',    'shape'=>'cube-star',    'color'=>'#C9A9F0', 'detail_color'=>'#FFE07A', 'price'=>13],
            ['slug'=>'sc5',  'name'=>'Star Cube Black',     'category'=>'figures', 'group'=>'Star Cubes',    'shape'=>'cube-star',    'color'=>'#3D3D52', 'detail_color'=>'#FFD700', 'price'=>13],
            // Checker Cubes
            ['slug'=>'cc1',  'name'=>'Checker Black',       'category'=>'figures', 'group'=>'Checker Cubes', 'shape'=>'cube-checker', 'color'=>'#F5F5FF', 'detail_color'=>'#3D3D52', 'price'=>14],
            ['slug'=>'cc2',  'name'=>'Checker Pink',        'category'=>'figures', 'group'=>'Checker Cubes', 'shape'=>'cube-checker', 'color'=>'#F9B8CF', 'detail_color'=>'#C0136A', 'price'=>14],
            ['slug'=>'cc3',  'name'=>'Checker Mint',        'category'=>'figures', 'group'=>'Checker Cubes', 'shape'=>'cube-checker', 'color'=>'#90DDD9', 'detail_color'=>'#0A9690', 'price'=>14],
            ['slug'=>'cc4',  'name'=>'Checker Lavender',    'category'=>'figures', 'group'=>'Checker Cubes', 'shape'=>'cube-checker', 'color'=>'#C9A9F0', 'detail_color'=>'#5E35C8', 'price'=>14, 'stock'=>'low'],
            // Smiley Cubes
            ['slug'=>'sm1',  'name'=>'Smiley Blush',        'category'=>'figures', 'group'=>'Smiley Cubes',  'shape'=>'cube-smile',   'color'=>'#F9B8CF', 'detail_color'=>'#3D3D52', 'price'=>13],
            ['slug'=>'sm2',  'name'=>'Smiley Mint',         'category'=>'figures', 'group'=>'Smiley Cubes',  'shape'=>'cube-smile',   'color'=>'#90DDD9', 'detail_color'=>'#3D3D52', 'price'=>13],
            ['slug'=>'sm3',  'name'=>'Smiley Butter',       'category'=>'figures', 'group'=>'Smiley Cubes',  'shape'=>'cube-smile',   'color'=>'#FFE07A', 'detail_color'=>'#3D3D52', 'price'=>13],
            ['slug'=>'sm4',  'name'=>'Smiley Lavender',     'category'=>'figures', 'group'=>'Smiley Cubes',  'shape'=>'cube-smile',   'color'=>'#C9A9F0', 'detail_color'=>'#3D3D52', 'price'=>13, 'stock'=>'low'],
        ];

        // ── Charms ────────────────────────────────────────────────────────────
        // img_path is relative to public/img/builder/
        // Full URL will be: asset('img/builder/' . $img_path)
        // Physical file location: public/img/builder/hello kitty/01.png
        //                         public/img/builder/bts/1.png
        $charms = [
            // Hello Kitty — folder name has a space, matching the actual directory
            ['slug'=>'fg1',  'name'=>'Hello Kitty 1', 'category'=>'charms', 'use_img'=>true, 'img_path'=>'hello kitty/01.png', 'series_id'=>$hkId,  'price'=>35, 'is_large'=>true],
            ['slug'=>'fg2',  'name'=>'Hello Kitty 2', 'category'=>'charms', 'use_img'=>true, 'img_path'=>'hello kitty/02.png', 'series_id'=>$hkId,  'price'=>35, 'is_large'=>true],
            ['slug'=>'fg3',  'name'=>'Hello Kitty 3', 'category'=>'charms', 'use_img'=>true, 'img_path'=>'hello kitty/03.png', 'series_id'=>$hkId,  'price'=>35, 'is_large'=>true],
            ['slug'=>'fg4',  'name'=>'Hello Kitty 4', 'category'=>'charms', 'use_img'=>true, 'img_path'=>'hello kitty/04.png', 'series_id'=>$hkId,  'price'=>35, 'is_large'=>true, 'stock'=>'low'],
            ['slug'=>'fg5',  'name'=>'Hello Kitty 5', 'category'=>'charms', 'use_img'=>true, 'img_path'=>'hello kitty/05.png', 'series_id'=>$hkId,  'price'=>35, 'is_large'=>true],
            // BTS
            ['slug'=>'bts1', 'name'=>'BTS RM',        'category'=>'charms', 'use_img'=>true, 'img_path'=>'bts/1.png', 'series_id'=>$btsId, 'price'=>40, 'is_large'=>true],
            ['slug'=>'bts2', 'name'=>'BTS Jin',       'category'=>'charms', 'use_img'=>true, 'img_path'=>'bts/2.png', 'series_id'=>$btsId, 'price'=>40, 'is_large'=>true],
            ['slug'=>'bts3', 'name'=>'BTS Suga',      'category'=>'charms', 'use_img'=>true, 'img_path'=>'bts/3.png', 'series_id'=>$btsId, 'price'=>40, 'is_large'=>true],
            ['slug'=>'bts4', 'name'=>'BTS J-Hope',    'category'=>'charms', 'use_img'=>true, 'img_path'=>'bts/4.png', 'series_id'=>$btsId, 'price'=>40, 'is_large'=>true],
            ['slug'=>'bts5', 'name'=>'BTS Jimin',     'category'=>'charms', 'use_img'=>true, 'img_path'=>'bts/5.png', 'series_id'=>$btsId, 'price'=>40, 'is_large'=>true],
            ['slug'=>'bts6', 'name'=>'BTS V',         'category'=>'charms', 'use_img'=>true, 'img_path'=>'bts/6.png', 'series_id'=>$btsId, 'price'=>40, 'is_large'=>true],
            ['slug'=>'bts7', 'name'=>'BTS Jungkook',  'category'=>'charms', 'use_img'=>true, 'img_path'=>'bts/7.png', 'series_id'=>$btsId, 'price'=>40, 'is_large'=>true],
        ];

        // ── Merge defaults and insert ─────────────────────────────────────────
        $now = now();
        $defaults = [
            'group'        => null,
            'shape'        => null,
            'color'        => null,
            'detail_color' => null,
            'use_img'      => false,
            'img_path'     => null,
            'series_id'    => null,
            'is_small'     => false,
            'is_large'     => false,
            'stock'        => 'in',
            'is_active'    => true,
            'created_at'   => $now,
            'updated_at'   => $now,
        ];

        $rows = collect([...$beads, ...$figures, ...$charms])
            ->map(fn ($row) => array_merge($defaults, $row))
            ->toArray();

        foreach (array_chunk($rows, 50) as $chunk) {
            DB::table('elements')->insertOrIgnore($chunk);
        }
    }
}