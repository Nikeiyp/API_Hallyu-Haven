<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/produk', function () {
    return view('pages.product'); // Buat view ini nanti
});

Route::get('/tentang', function () {
    return view('pages.about'); // Buat view ini juga
});

Route::get('/kontak', function () {
    return view('pages.contact'); // Buat view ini juga
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
