<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/nosotros', function () {
    return view('poximamnete');
})->name('nosotros');

Route::get('/productos', function () {
    return view('Modules.Home.products');
})->name('productos');


Route::get('/stickers', function () {
    return view('Modules.Home.stickers');
})->name('stickers');


Route::get('/contacto', function () {
    return view('poximamnete');
})->name('contacto');


