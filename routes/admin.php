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

Route::get('/catalogos/colores', function () {
    return view('Modules.Catalogos.colores');
})->name('catalogos.colores');

Route::get('/catalogos/maquinas', function () {
    return view('Modules.Catalogos.maquinas');
})->name('catalogos.maquinas');



Route::get('/diseños', function () {
    return view('Modules.Diseños.index');
})->name('disenos.index');

Route::get('/diseños/create', function () {
    return view('Modules.Diseños.create');
})->name('disenos.create');

Route::get('/diseños/edit/{id}', function ($id) {
    return view('Modules.Diseños.edit',['id' => $id]);
})->name('disenos.edit');


Route::get('/productos', function () {
    return view('Modules.Productos.index');
})->name('productos.index');

Route::get('/productos/create', function () {
    return view('Modules.Productos.create');
})->name('productos.create');

Route::get('/productos/edit/{id}', function ($id) {
    return view('Modules.Productos.edit',['id' => $id]);
})->name('productos.edit');



Route::get('/ventas', function () {
    return view('dashboard');
})->name('ventas.index');

Route::get('/ventas/create', function () {
    return view('dashboard');
})->name('ventas.create');

Route::get('/ventas/edit/{id}', function ($id) {
    return view('dashboard', ['id' => $id]);
})->name('ventas.edit');
