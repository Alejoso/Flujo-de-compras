<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$controllerRoute = 'App\Http\Controllers';

// Routes exclusively for admin
Route::middleware('admin')->group(function () use ($controllerRoute) {

    // User routes
    Route::get('/admin/usuario', $controllerRoute.'\Admin\UserController@index')->name('admin.user.index');
    Route::get('/admin/usuario/crear', $controllerRoute.'\Admin\UserController@create')->name('admin.user.create');
    Route::post('/admin/usuario/guardar', $controllerRoute.'\Admin\UserController@save')->name('admin.user.save');
    Route::get('/admin/usuario/{id}/editar', $controllerRoute.'\Admin\UserController@edit')->name('admin.user.edit');
    Route::patch('/admin/usuario/{id}', $controllerRoute.'\Admin\UserController@update')->name('admin.user.update');
    Route::delete('/admin/usuario/{id}', $controllerRoute.'\Admin\UserController@destroy')->name('admin.user.destroy');

    // Notification routes
    Route::get('/admin/notificacion', $controllerRoute.'\Admin\NotificationController@index')->name('admin.notification.index');
    Route::patch('/admin/notificacion/guardar', $controllerRoute.'\Admin\NotificationController@save')->name('admin.notification.save');
    Route::patch('/admin/notificacion/eliminar/{id}', $controllerRoute.'\Admin\NotificationController@destroy')->name('admin.notification.destroy');
    Route::get('/admin/notificacion/enviar', $controllerRoute.'\Admin\NotificationController@send')->name('admin.notification.send');

    // Test routes
    Route::get('/admin/notificacion/correo', $controllerRoute.'\Admin\NotificationController@correo')->name('admin.notification.correo');
    Route::get('/admin/notificacion/test', $controllerRoute.'\Admin\NotificationController@test')->name('admin.notification.test');

    // OCR routes
    Route::post('/admin/factura/OCR', $controllerRoute.'\Admin\OCRController@process')->name('admin.OCR.process');

    // Invoice routes
    Route::get('/admin/factura', $controllerRoute.'\Admin\InvoiceController@index')->name('admin.invoice.index');

    // Project routes
    Route::get('/admin/proyecto', $controllerRoute.'\Admin\ProjectController@index')->name('admin.project.index');
    Route::get('/admin/proyecto/crear', $controllerRoute.'\Admin\ProjectController@create')->name('admin.project.create');
    Route::post('/admin/proyecto/guardar', $controllerRoute.'\Admin\ProjectController@save')->name('admin.project.save');
    Route::get('/admin/proyecto/{id}/editar', $controllerRoute.'\Admin\ProjectController@edit')->name('admin.project.edit');
    Route::get('/admin/proyecto/{id}', $controllerRoute.'\Admin\ProjectController@show')->name('admin.project.show');
    Route::get('/admin/proyecto/{id}/cotizaciones', $controllerRoute.'\Admin\ProjectController@showQuotations')->name('admin.project.showQuotations');
    Route::get('/admin/materiales/buscar', $controllerRoute.'\Technician\MaterialTypeController@search')->name('admin.materials.search');
    Route::get('/admin/proyecto/{id}/cotizacion/{quotationId}/versiones', $controllerRoute.'\Admin\QuotationController@versions')->name('admin.quotation.versions');
    Route::get('/admin/proyecto/{id}/cotizacion/{versionId}/detalle', $controllerRoute.'\Admin\QuotationController@show')->name('admin.quotation.show');
    Route::get('/admin/proyecto/{id}/cotizacion/{versionId}/editar', $controllerRoute.'\Admin\QuotationController@edit')->name('admin.quotation.edit');
    Route::patch('/admin/proyecto/{id}/cotizacion/{versionId}/actualizar', $controllerRoute.'\Admin\QuotationController@update')->name('admin.quotation.update');
    Route::post('/admin/proyecto/{id}/cotizacion/{quotationId}/aceptar', $controllerRoute.'\Admin\QuotationController@accept')->name('admin.quotation.accept');
    Route::post('/admin/proyecto/{id}/cotizacion/{quotationId}/rechazar', $controllerRoute.'\Admin\QuotationController@reject')->name('admin.quotation.reject');
    Route::patch('/admin/proyecto/{id}', $controllerRoute.'\Admin\ProjectController@update')->name('admin.project.update');
    Route::delete('/admin/proyecto/{id}', $controllerRoute.'\Admin\ProjectController@destroy')->name('admin.project.destroy');

    // Client routes
    Route::get('/admin/cliente', $controllerRoute.'\Admin\ClientController@index')->name('admin.client.index');
    Route::get('/admin/cliente/crear', $controllerRoute.'\Admin\ClientController@create')->name('admin.client.create');
    Route::post('/admin/cliente/guardar', $controllerRoute.'\Admin\ClientController@save')->name('admin.client.save');
    Route::get('/admin/cliente/{id}/editar', $controllerRoute.'\Admin\ClientController@edit')->name('admin.client.edit');
    Route::get('/admin/cliente/{id}', $controllerRoute.'\Admin\ClientController@show')->name('admin.client.show');
    Route::patch('/admin/cliente/{id}', $controllerRoute.'\Admin\ClientController@update')->name('admin.client.update');
    Route::delete('/admin/cliente/{id}', $controllerRoute.'\Admin\ClientController@destroy')->name('admin.client.destroy');

    // Supplier routes
    Route::get('/admin/proveedor', $controllerRoute.'\Admin\SupplierController@index')->name('admin.supplier.index');
    Route::get('/admin/proveedor/crear', $controllerRoute.'\Admin\SupplierController@create')->name('admin.supplier.create');
    Route::post('/admin/proveedor/guardar', $controllerRoute.'\Admin\SupplierController@save')->name('admin.supplier.save');
    Route::get('/admin/proveedor/{id}/editar', $controllerRoute.'\Admin\SupplierController@edit')->name('admin.supplier.edit');
    Route::patch('/admin/proveedor/{id}', $controllerRoute.'\Admin\SupplierController@update')->name('admin.supplier.update');
    Route::delete('/admin/proveedor/{id}', $controllerRoute.'\Admin\SupplierController@destroy')->name('admin.supplier.destroy');

    // Material routes
    Route::get('/admin/material', $controllerRoute.'\Admin\MaterialController@index')->name('admin.material.index');
    Route::get('/admin/material/crear', $controllerRoute.'\Admin\MaterialController@create')->name('admin.material.create');
    Route::post('/admin/material', $controllerRoute.'\Admin\MaterialController@save')->name('admin.material.save');
    Route::delete('/admin/material/{id}', $controllerRoute.'\Admin\MaterialController@destroy')->name('admin.material.destroy');
});

// Routes exclusively for technician
Route::middleware('technician')->group(function () use ($controllerRoute) {
    Route::get('/tecnico/proyecto', $controllerRoute.'\Technician\ProjectController@index')->name('technician.project.index');
    Route::get('/tecnico/proyecto/{id}/cotizacion', $controllerRoute.'\Technician\QuotationController@index')->name('technician.quotation.index');
    Route::get('/tecnico/proyecto/{id}/cotizacion/crear', $controllerRoute.'\Technician\QuotationController@create')->name('technician.quotation.create');
    Route::post('/tecnico/proyecto/{id}/cotizacion', $controllerRoute.'\Technician\QuotationController@store')->name('technician.quotation.store');
    Route::get('/tecnico/proyecto/{id}/cotizacion/{quotationId}/versiones', $controllerRoute.'\Technician\QuotationController@versions')->name('technician.quotation.versions');
    Route::post('/tecnico/proyecto/{id}/cotizacion/{quotationId}/enviar', $controllerRoute.'\Technician\QuotationController@submit')->name('technician.quotation.submit');
    Route::get('/tecnico/proyecto/{id}/cotizacion/{versionId}', $controllerRoute.'\Technician\QuotationController@show')->name('technician.quotation.show');
    Route::get('/tecnico/proyecto/{id}/cotizacion/{versionId}/editar', $controllerRoute.'\Technician\QuotationController@edit')->name('technician.quotation.edit');
    Route::patch('/tecnico/proyecto/{id}/cotizacion/{versionId}/actualizar', $controllerRoute.'\Technician\QuotationController@update')->name('technician.quotation.update');
    Route::get('/tecnico/proyecto/{id}/cotizacion/{versionId}/pdf', $controllerRoute.'\Technician\QuotationPdfController@pdfView')->name('technician.quotation.pdfView');
    Route::get('/tecnico/proyecto/{id}/cotizacion/{versionId}/pdf/descargar', $controllerRoute.'\Technician\QuotationPdfController@pdfDownload')->name('technician.quotation.pdfDownload');
    Route::get('/tecnico/materiales/buscar', $controllerRoute.'\Technician\MaterialTypeController@search')->name('technician.materials.search');
});

Auth::routes(['register' => false]);
Route::redirect('/', '/login');
