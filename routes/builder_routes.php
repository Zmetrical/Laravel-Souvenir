<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\builder\BraceletController;
use App\Http\Controllers\builder\KeychainController;
use App\Http\Controllers\builder\NecklaceController;
use App\Http\Controllers\builder\BuilderOrderController;

Route::get('/', fn() => view('builder.index'))->name('index');

// ── Builder pages ─────────────────────────────────────────────────────────────
Route::get('/keychain', [KeychainController::class, 'index'])->name('keychain');
Route::get('/bracelet', [BraceletController::class, 'index'])->name('bracelet');
Route::get('/necklace', [NecklaceController::class, 'index'])->name('necklace');

// ── Order flow ────────────────────────────────────────────────────────────────
Route::post('/order/preview',            [BuilderOrderController::class, 'preview'])->name('order.preview');
Route::get('/order/create',              [BuilderOrderController::class, 'create'])->name('order.create');
Route::post('/order',                    [BuilderOrderController::class, 'store'])->name('order.store');
Route::get('/order/{code}/confirmation', [BuilderOrderController::class, 'confirmation'])->name('order.confirmation');
Route::get('/order/{code}/status',       [BuilderOrderController::class, 'status'])->name('order.status');