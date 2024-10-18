<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('users', UserController::class)->middleware('auth:api')->only(['index','show','update','destroy']);
    Route::apiResource('users', UserController::class)->only(['store']);
});


Route::prefix('v1/users/auth')->group(function () {
    Route::post('login',[AuthController::class, 'login']);
    Route::post('logout',[AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh',[AuthController::class, 'refresh'])->middleware('auth:api');
});


