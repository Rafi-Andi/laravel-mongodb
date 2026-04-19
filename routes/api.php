<?php

use App\Http\Controllers\Api\LoginController;

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\JwtMiddleware;

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::apiResource('/invoice', InvoiceController::class);
});

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);