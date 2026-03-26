<?php

// ── Add this to your routes/web.php ──────────────────────────────────────────
// Place inside a middleware group (e.g. auth) as appropriate
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\ElementController;

// Elements CRUD
Route::resource('elements', ElementController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

// You can add more admin routes here later:
// Route::resource('products', AdminProductController::class);
// Route::resource('orders',   AdminOrderController::class);