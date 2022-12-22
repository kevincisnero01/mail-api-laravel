<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// === PUBLIC ===
Route::post('register',[AuthController::class,'register'])->name('register');

Route::post('login',[AuthController::class,'login'])->name('login');


// === PRIVATE ===
Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout',[AuthController::class,'logout'])->name('logout');

});


