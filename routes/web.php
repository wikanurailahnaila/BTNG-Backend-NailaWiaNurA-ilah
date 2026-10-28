<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Halaman demo interaktif CRUD /api/mobil
Route::get('/contohCRUD', function () {
    return view('contohcrud');
});
