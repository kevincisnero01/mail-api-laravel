<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// === PUBLIC ===
Route::post('register',[AuthController::class,'register'])->name('register');

Route::post('login',[AuthController::class,'login'])->name('login');

Route::post('/forgot-password',[ForgotPasswordController::class,'send_email'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}',[ForgotPasswordController::class,'get_token'])->middleware('guest')->name('password.reset');

Route::post('/reset-password',[ForgotPasswordController::class,'reset_update'])->middleware('guest')->name('password.update');

// === PRIVATE ===
Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout',[AuthController::class,'logout'])->name('logout');

});


