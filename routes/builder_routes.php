<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\AccountController;

Route::controller(MainController::class)->group(function(){
    Route::get('/', 'index')->name('.index');
});
