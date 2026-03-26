<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\builder\BraceletController;
use App\Http\Controllers\builder\KeychainController;
use App\Http\Controllers\builder\NecklaceController;

Route::controller(KeychainController::class)->group(function(){
    Route::get('/keychain', 'index')->name('.keychain');
});

Route::controller(BraceletController::class)->group(function(){
    Route::get('/bracelet', 'index')->name('.bracelet');
});

Route::controller(NecklaceController::class)->group(function(){
    Route::get('/necklace', 'index')->name('.necklace');
});
