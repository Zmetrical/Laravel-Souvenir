<?php

namespace App\Http\Controllers\builder;

use App\Http\Controllers\Controller;
use App\Models\builder\Product;
use App\Models\builder\Element;

abstract class BuilderController extends Controller
{
    // ── Shared: load all active elements from DB ──────────────────────────────
    // Returns a JS-ready array split into beads / figures / charms
    // This replaces the static data.js files — injected into the page as JSON
    protected function getElementsPayload(): array
    {
        $elements = Element::with('series')
            ->active()
            ->get();

        return [
            'beads'   => $elements->where('category', 'beads')
                                  ->values()
                                  ->map->toCanvasArray()
                                  ->values(),

            'figures' => $elements->where('category', 'figures')
                                  ->values()
                                  ->map->toCanvasArray()
                                  ->values(),

            'charms'  => $elements->where('category', 'charms')
                                  ->values()
                                  ->map->toCanvasArray()
                                  ->values(),
        ];
    }

    // ── Shared: load product config from DB ───────────────────────────────────
    protected function getProduct(string $slug): Product
    {
        return Product::where('slug', $slug)
                      ->where('is_active', true)
                      ->firstOrFail();
    }
}