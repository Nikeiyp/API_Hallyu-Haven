<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MerchandiseController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Tidak Perlu Login)
|--------------------------------------------------------------------------
*/
// Menampilkan semua merchandise (untuk halaman PLP)
Route::get('/merchandise', [MerchandiseController::class, 'index']);

// Menampilkan detail satu merchandise (untuk halaman PDP)
Route::get('/merchandise/{id}', [MerchandiseController::class, 'show']);

// Menampilkan merchandise untuk slider di home
Route::get('/slider-merchandise', [MerchandiseController::class, 'slider']);


/*
|--------------------------------------------------------------------------
| Rute Autentikasi User
|--------------------------------------------------------------------------
*/
Route::prefix('user')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    // Rute di bawah ini memerlukan login
    Route::middleware('auth:api')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/whoami', function (Request $request) {
            return $request->user();
        });
    });
});


/*
|--------------------------------------------------------------------------
| Rute Admin (Memerlukan Login)
|--------------------------------------------------------------------------
*/  
Route::middleware('auth:api')->group(function(){
    // Hanya user yang sudah login yang bisa melakukan aksi di bawah ini
    Route::post('/merchandise', [MerchandiseController::class, 'store']);
    Route::put('/merchandise/{id}', [MerchandiseController::class, 'update']);
    Route::delete('/merchandise/{id}', [MerchandiseController::class, 'destroy']);
});