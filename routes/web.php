<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/nosotros', function () {
    return view('poximamnete');
})->name('nosotros');

Route::get('/productos', function () {
    //return view('Modules.Home.products');
    return view('poximamnete');
})->name('productos');


Route::get('/stickers', function () {
    return view('Modules.Home.stickers.index');
})->name('stickers.index');

Route::get('/stickers/{slug}', function ($slug) {
    return view('Modules.Home.stickers.read', ['slug' => $slug]);
})->name('stickers.read');


Route::get('/contacto', function () {
    return view('poximamnete');
})->name('contacto');
