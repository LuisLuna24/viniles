<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/componentes', function () {
        return view('componentes.index');
    })->name('componentes.index');
});

//==================================================================================Componentes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/ensambles', function () {
        return view('componentes.ensambles');
    })->name('componentes.ensambles');

    Route::get('/fuentes_poder', function () {
        return view('componentes.fuente_poder');
    })->name('componentes.fuente_poder');

    Route::get('/gabinetes', function () {
        return view('componentes.gabinete');
    })->name('componentes.gabinete');

    Route::get('/discos_hdd', function () {
        return view('componentes.hdd');
    })->name('componentes.hdd');

    Route::get('/discos_ssd', function () {
        return view('componentes.ssd');
    })->name('componentes.ssd');

    Route::get('/procesadores', function () {
        return view('componentes.procesador');
    })->name('componentes.procesador');

    Route::get('/memoria_ram', function () {
        return view('componentes.ram');
    })->name('componentes.ram');

    Route::get('/targetas_madre', function () {
        return view('componentes.targeta_madre');
    })->name('componentes.targeta_madre');

    Route::get('/targetas_video', function () {
        return view('componentes.targeta_video');
    })->name('componentes.targeta_video');
});
