<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ElementController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| Admin Routes  →  /admin/*
|--------------------------------------------------------------------------
| Prefix : /admin
| Name   : admin.
|--------------------------------------------------------------------------
*/

// ── Elements Overview ──────────────────────────────────────────────────────
Route::get('elements',                [ElementController::class, 'overview'])->name('elements.index');

// ── Category Pages ─────────────────────────────────────────────────────────
Route::get('elements/beads',          [ElementController::class, 'beads'   ])->name('elements.beads');
Route::get('elements/figures',        [ElementController::class, 'figures' ])->name('elements.figures');
Route::get('elements/charms',         [ElementController::class, 'charms'  ])->name('elements.charms');

// ── Create / Store ─────────────────────────────────────────────────────────
Route::get('elements/create',         [ElementController::class, 'create'  ])->name('elements.create');
Route::post('elements',               [ElementController::class, 'store'   ])->name('elements.store');

// ── Edit / Update / Delete ─────────────────────────────────────────────────
Route::get(   'elements/{element}/edit', [ElementController::class, 'edit'   ])->name('elements.edit');
Route::put(   'elements/{element}',      [ElementController::class, 'update' ])->name('elements.update');
Route::delete('elements/{element}',      [ElementController::class, 'destroy'])->name('elements.destroy');



// ── Products (coming soon) ─────────────────────────────────────────────────
// Route::get(    'products',             [ProductController::class, 'index'  ])->name('products.index');
// Route::get(    'products/create',      [ProductController::class, 'create' ])->name('products.create');
// Route::post(   'products',             [ProductController::class, 'store'  ])->name('products.store');
// Route::get(    'products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Route::put(    'products/{product}',   [ProductController::class, 'update' ])->name('products.update');
// Route::delete( 'products/{product}',   [ProductController::class, 'destroy'])->name('products.destroy');

// ── Orders (coming soon) ───────────────────────────────────────────────────
Route::get('/orders',                   [OrderController::class, 'index'])       ->name('orders.index');
Route::get('/orders/{order}',           [OrderController::class, 'show'])        ->name('orders.show');
Route::post('/orders/{order}/status',   [OrderController::class, 'updateStatus'])->name('orders.status');
Route::get('/orders/{order}/print',     [OrderController::class, 'printView'])   ->name('orders.print');
