<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MerchandiseController;

Route::prefix('user')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('/whoami', function (Request $request) {
        return $request->user();
    })->middleware('auth:api');
});

Route::middleware('auth:api')->group(function(){
        Route::get('/merchandise', [MerchandiseController::class, 'index']);
        Route::get('/merchandise/{id}', [MerchandiseController::class, 'show']);
        Route::post('/merchandise', [MerchandiseController::class, 'store']);
        Route::put('/merchandise/{id}', [MerchandiseController::class, 'update']);
        Route::delete('/merchandise/{id}', [MerchandiseController::class, 'destroy']);
    });

Route::get('/merchandise', [MerchandiseController::class, 'index']);
Route::get('/slider-merchandise', [MerchandiseController::class, 'slider']);