<?php

use Illuminate\Support\Facades\Route;

$controllerRoute = 'App\Http\Controllers';

// Rutas exclusivamente para admin
Route::middleware('admin')->group(function () use ($controllerRoute) {
    Route::get('/admin', $controllerRoute.'\Admin\AdminHomeController@index')->name('admin.home');
});

// Rutas exclusivamente para tecnico
Route::middleware('tecnico')->group(function () use ($controllerRoute) {
    Route::get('/tecnico', $controllerRoute.'\Tecnico\TecnicoHomeController@index')->name('tecnico.home');
});

Auth::routes(['register' => false]);
