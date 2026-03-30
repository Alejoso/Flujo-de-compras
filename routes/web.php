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
Route::get('/', $controllerRoute . '\NotificationController@index')->name('notification.index');
Route::get('/notification/send', $controllerRoute . '\NotificationController@send')->name('notification.send');
Route::patch('/notification/save', $controllerRoute .'\NotificationController@save')->name('notification.save');
Route::get('/notification/correo', $controllerRoute .'\NotificationController@correo')->name('notification.correo');
Route::get('/notification/test', $controllerRoute .'\NotificationController@test')->name('notification.test');
Route::patch('/notification/destroy/{id}', $controllerRoute .'\NotificationController@destroy')->name('notification.destroy');

Route::get('/user', $controllerRoute .'\UserController@index')->name('user.index');
Route::get('/user/create', $controllerRoute .'\UserController@create')->name('user.create');
Route::post('/user/save', $controllerRoute .'\UserController@save')->name('user.save');
