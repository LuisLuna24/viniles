<?php

use Illuminate\Support\Facades\Route;

Route::get('/panel', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/catalogos/categorias', function () {
    return view('Modules.Catalogos.categorias');
})->name('catalogos.categorias');

Route::get('/catalogos/subcategorias', function () {
    return view('Modules.Catalogos.subcategorias');
})->name('catalogos.subcategorias');

Route::get('/catalogos/marcas', function () {
    return view('Modules.Catalogos.marcas');
})->name('catalogos.marcas');

Route::get('/catalogos/modelos', function () {
    return view('Modules.Catalogos.modelos');
})->name('catalogos.modelos');

Route::get('/catalogos/unidades', function () {
    return view('Modules.Catalogos.unidades');
})->name('catalogos.unidades');



Route::get('/configuraciones', function () {
    return view('Modules.Configuraciones.index');
})->name('configuraciones.index');

Route::get('/configuraciones/create', function () {
    return view('Modules.Configuraciones.create');
})->name('configuraciones.create');

Route::get('/configuraciones/edit/{id}', function ($id) {
    return view('Modules.Configuraciones.edit',['id' => $id]);
})->name('configuraciones.edit');



Route::get('/productos', function () {
    return view('Modules.Productos.index');
})->name('productos.index');

Route::get('/productos/create', function () {
    return view('Modules.Productos.create');
})->name('productos.create');

Route::get('/productos/edit/{id}', function ($id) {
    return view('Modules.Productos.edit', ['id' => $id]);
})->name('productos.edit');



Route::get('/stickers', function () {
    return view('Modules.Stickers.index');
})->name('stickers.index');

Route::get('/stickers/create', function () {
    return view('Modules.Stickers.create');
})->name('stickers.create');

Route::get('/stickers/edit/{id}', function ($id) {
    return view('Modules.Stickers.edit', ['id' => $id]);
})->name('stickers.edit');



Route::get('/ventas', function () {
    return view('dashboard');
})->name('ventas.index');

Route::get('/ventas/create', function () {
    return view('dashboard');
})->name('ventas.create');

Route::get('/ventas/edit/{id}', function ($id) {
    return view('dashboard', ['id' => $id]);
})->name('ventas.edit');
