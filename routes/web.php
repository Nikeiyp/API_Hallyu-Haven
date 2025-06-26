<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/merch', function () {
    return view('pages.plp'); // Buat view ini nanti
})->name('plp');

Route::get('/merch/{i}', function () {
    return view('pages.pdp'); // Buat view ini nanti
})->name('pdp');