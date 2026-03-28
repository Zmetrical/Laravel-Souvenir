<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Account\AccountController;
use Illuminate\Support\Facades\Route;

// ── Root ───────────────────────────────────────────────────────────────────────
Route::get('/', fn () => view('welcome'))->name('home');

// ── Auth ───────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',   [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register',[RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ── Customer account ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'customer'])
    ->prefix('account')
    ->name('account.')
    ->group(function () {
        Route::get('/',        [AccountController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders',  [AccountController::class, 'orders'])->name('orders');
        Route::get('/designs', [AccountController::class, 'designs'])->name('designs');

        // add this
        Route::delete('/designs/{design}', [AccountController::class, 'destroyDesign'])
             ->name('designs.destroy');
    });