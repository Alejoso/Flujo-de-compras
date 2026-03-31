<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$controllerRoute = 'App\Http\Controllers';

// Rutas exclusivamente para admin
Route::middleware('admin')->group(function () use ($controllerRoute) {
    Route::get('/admin', $controllerRoute.'\Admin\AdminHomeController@index')->name('admin.home');

    // User routes
    Route::get('/admin/user', $controllerRoute.'\Admin\UserController@index')->name('admin.user.index');
    Route::get('/admin/user/create', $controllerRoute.'\Admin\UserController@create')->name('admin.user.create');
    Route::post('/admin/user/save', $controllerRoute.'\Admin\UserController@save')->name('admin.user.save');
    Route::get('/admin/user/{id}/edit', $controllerRoute.'\Admin\UserController@edit')->name('admin.user.edit');
    Route::patch('/admin/user/{id}', $controllerRoute.'\Admin\UserController@update')->name('admin.user.update');
    Route::delete('/admin/user/{id}', $controllerRoute.'\Admin\UserController@destroy')->name('admin.user.destroy');

    // Notification routes
    Route::get('/admin/notification', $controllerRoute.'\Admin\NotificationController@index')->name('admin.notification.index');
    Route::patch('/admin/notification/save', $controllerRoute.'\Admin\NotificationController@save')->name('admin.notification.save');
    Route::patch('/admin/notification/destroy/{id}', $controllerRoute.'\Admin\NotificationController@destroy')->name('admin.notification.destroy');
    Route::get('/admin/notification/send', $controllerRoute.'\Admin\NotificationController@send')->name('admin.notification.send');

    // Test routes
    Route::get('/admin/notification/correo', $controllerRoute.'\Admin\NotificationController@correo')->name('admin.notification.correo');
    Route::get('/admin/notification/test', $controllerRoute.'\Admin\NotificationController@test')->name('admin.notification.test');

    // OCR routes
    Route::post('/admin/invoice/OCR', $controllerRoute.'\Admin\OCRController@process')->name('admin.OCR.process');

    // Invoice routes
    Route::get('/admin/invoice', $controllerRoute.'\Admin\InvoiceController@index')->name('admin.invoice.index');

    // Project routes
    Route::get('/admin/project', $controllerRoute.'\Admin\ProjectController@index')->name('admin.project.index');
    Route::get('/admin/project/create', $controllerRoute.'\Admin\ProjectController@create')->name('admin.project.create');
    Route::get('/admin/project/{id}', $controllerRoute.'\Admin\ProjectController@show')->name('admin.project.show');
    Route::post('/admin/project/save', $controllerRoute.'\Admin\ProjectController@save')->name('admin.project.save');
    Route::post('/admin/project/{id}\edit', $controllerRoute.'\Admin\ProjectController@update')->name('admin.project.edit');
});

// Rutas exclusivamente para tecnico
Route::middleware('tecnico')->group(function () use ($controllerRoute) {
    Route::get('/tecnico', $controllerRoute.'\Tecnico\TecnicoHomeController@index')->name('tecnico.home');
});

Auth::routes(['register' => false]);
Route::redirect('/', '/login');

