<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MerchandiseController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/merchandise', function () {
    return view('pages.plp');
    })->name('plp');
    
    Route::get('/merchandise/{i}', function () {
        return view('pages.pdp');
        })->name('pdp');