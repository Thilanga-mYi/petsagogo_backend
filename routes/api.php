<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("auth")->group(function () {
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix("user")->middleware("auth:sanctum")->group(function () {
    Route::post('verify', [AuthController::class, 'verify']);
});
