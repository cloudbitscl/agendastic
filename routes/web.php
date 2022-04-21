<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['as'=>'data.', 'prefix' => 'data'], function(){
    Route::post('/servicios', [\App\Http\Controllers\DataController::class, 'getServicios'])->name('servicios');
    Route::post('/proveedores', [\App\Http\Controllers\DataController::class, 'getProveedores'])->name('proveedores');
    Route::post('/servicios-proveedor/{proveedor_id?}', [\App\Http\Controllers\DataController::class, 'getServiciosProveedor'])->name('servicios-proveedor');
    Route::post('/proveedores-servicio/{servicio_id?}', [\App\Http\Controllers\DataController::class, 'getProveedoresServicio'])->name('proveedores-servicio');
    Route::post('/dias-proveedor-servicio', [\App\Http\Controllers\DataController::class, 'getDiasProveedorServicio'])->name('dias-proveedor-servicio');
    Route::post('/horas-dia-proveedor-servicio', [\App\Http\Controllers\DataController::class, 'getHorasDiaProveedorServicio'])->name('horas-dia-proveedor-servicio');
});

Route::group(['as'=>'cliente.'], function () {
    
    Route::get('/', [\App\Http\Controllers\Cliente\InicioController::class, 'index'])->name('inicio.index');
});


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){    
    
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');
    Route::get('/login/password-request', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('password.request');
    Route::get('/logout', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('logout');

    
    Route::get('/', [App\Http\Controllers\Admin\PanelController::class, 'index'])->name('panel.index');
});


