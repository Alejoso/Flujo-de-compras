<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$controllerRoute = 'App\Http\Controllers';

// Rutas exclusivamente para admin
Route::middleware('admin')->group(function () use ($controllerRoute) {

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
    Route::post('/admin/project/save', $controllerRoute.'\Admin\ProjectController@save')->name('admin.project.save');
    Route::get('/admin/project/{id}/edit', $controllerRoute.'\Admin\ProjectController@edit')->name('admin.project.edit');
    Route::get('/admin/project/{id}', $controllerRoute.'\Admin\ProjectController@show')->name('admin.project.show');
    Route::patch('/admin/project/{id}', $controllerRoute.'\Admin\ProjectController@update')->name('admin.project.update');

    // Client routes
    Route::get('/admin/client', $controllerRoute.'\Admin\ClientController@index')->name('admin.client.index');
    Route::get('/admin/client/create', $controllerRoute.'\Admin\ClientController@create')->name('admin.client.create');
    Route::post('/admin/client/save', $controllerRoute.'\Admin\ClientController@save')->name('admin.client.save');
    Route::get('/admin/client/{id}/edit', $controllerRoute.'\Admin\ClientController@edit')->name('admin.client.edit');
    Route::get('/admin/client/{id}', $controllerRoute.'\Admin\ClientController@show')->name('admin.client.show');
    Route::patch('/admin/client/{id}', $controllerRoute.'\Admin\ClientController@update')->name('admin.client.update');
    Route::delete('/admin/client/{id}', $controllerRoute.'\Admin\ClientController@destroy')->name('admin.client.destroy');

});

// Rutas exclusivamente para tecnico
Route::middleware('tecnico')->group(function () use ($controllerRoute) {
    Route::get('/tecnico/project', $controllerRoute.'\Tecnico\ProjectController@index')->name('tecnico.project.index');
    Route::get('/tecnico/project/{id}/cotizacion', $controllerRoute.'\Tecnico\CotizacionController@index')->name('tecnico.cotizacion.index');
    Route::get('/tecnico/project/{id}/cotizacion/create', $controllerRoute.'\Tecnico\CotizacionController@create')->name('tecnico.cotizacion.create');
    Route::post('/tecnico/project/{id}/cotizacion', $controllerRoute.'\Tecnico\CotizacionController@store')->name('tecnico.cotizacion.store');
    Route::get('/tecnico/project/{id}/cotizacion/{cotizacionId}/versiones', $controllerRoute.'\Tecnico\CotizacionController@versions')->name('tecnico.cotizacion.versions');
    Route::get('/tecnico/project/{id}/cotizacion/{versionId}', $controllerRoute.'\Tecnico\CotizacionController@show')->name('tecnico.cotizacion.show');
    Route::get('/tecnico/project/{id}/cotizacion/{versionId}/edit', $controllerRoute.'\Tecnico\CotizacionController@edit')->name('tecnico.cotizacion.edit');
    Route::patch('/tecnico/project/{id}/cotizacion/{versionId}/update', $controllerRoute.'\Tecnico\CotizacionController@update')->name('tecnico.cotizacion.update');
    Route::get('/tecnico/project/{id}/cotizacion/{versionId}/pdf', $controllerRoute.'\Tecnico\CotizacionPdfController@pdfView')->name('tecnico.cotizacion.pdfView');
    Route::get('/tecnico/project/{id}/cotizacion/{versionId}/pdf/download', $controllerRoute.'\Tecnico\CotizacionPdfController@pdfDownload')->name('tecnico.cotizacion.pdfDownload');
    Route::get('/materiales/buscar', $controllerRoute.'\Tecnico\TipoMaterialController@search')->name('tecnico.materiales.search');
});

Auth::routes(['register' => false]);
Route::redirect('/', '/login');
