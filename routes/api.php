<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::middleware('auth')->post('/me', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')->group(function () {
    Route::post('register',[AuthController::class,'register'])->name('register');
    Route::post('login',[AuthController::class,'login'])->name('login');
});

Route::middleware('api-token')->group(function () {
    Route::apiResource('/user',UserController::class);
    Route::apiResource('/product', ProductController::class);
    Route::get('/iam', [AuthController::class,'iam'])->name('iam');
});

