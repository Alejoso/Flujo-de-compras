<?php

use Illuminate\Support\Facades\Route;

$controllerRoute = 'App\Http\Controllers';

// Rutas exclusivamente para admin
Route::middleware('admin')->group(function () use ($controllerRoute) {
    Route::get('/admin', $controllerRoute.'\Admin\AdminHomeController@index')->name('admin.home');
    Route::get('/admin/user', $controllerRoute.'\Admin\UserController@index')->name('admin.user.index');
    Route::get('/admin/user/create', $controllerRoute.'\Admin\UserController@create')->name('admin.user.create');
    Route::post('/admin/user/save', $controllerRoute.'\Admin\UserController@save')->name('admin.user.save');
    Route::get('/admin/user/{id}/edit', $controllerRoute.'\Admin\UserController@edit')->name('admin.user.edit');
    Route::patch('/admin/user/{id}', $controllerRoute.'\Admin\UserController@update')->name('admin.user.update');
    Route::delete('/admin/user/{id}', $controllerRoute.'\Admin\UserController@destroy')->name('admin.user.destroy');

    Route::get('/admin/notification', $controllerRoute.'\Admin\NotificationController@index')->name('admin.notification.index');
    Route::patch('/admin/notification/save', $controllerRoute.'\Admin\NotificationController@save')->name('admin.notification.save');
    Route::patch('/admin/notification/destroy/{id}', $controllerRoute.'\Admin\NotificationController@destroy')->name('admin.notification.destroy');
    Route::get('/admin/notification/send', $controllerRoute.'\Admin\NotificationController@send')->name('admin.notification.send');
    Route::get('/admin/notification/correo', $controllerRoute.'\Admin\NotificationController@correo')->name('admin.notification.correo');
    Route::get('/admin/notification/test', $controllerRoute.'\Admin\NotificationController@test')->name('admin.notification.test');
});

// Rutas exclusivamente para tecnico
Route::middleware('tecnico')->group(function () use ($controllerRoute) {
    Route::get('/tecnico', $controllerRoute.'\Tecnico\TecnicoHomeController@index')->name('tecnico.home');
});

Auth::routes(['register' => false]);

