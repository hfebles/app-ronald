<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\RetencionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/xd', [App\Http\Controllers\HomeController::class, 'test'])->name('test');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('/proveedor', ProveedorController::class);
    Route::post('/proveedor/consulta', [ProveedorController::class, 'consulta_rif'])->name('proveedor.consulta');
    Route::post('/proveedor/eliminar', [ProveedorController::class, 'eliminar'])->name('proveedor.eliminar');

    Route::resource('/retenciones', RetencionController::class);
    Route::post('/proveedor/nro-factura', [RetencionController::class, 'validarNumeroFactura'])->name('retenciones.nro-factura');
    Route::post('/proveedor/nro-control', [RetencionController::class, 'validarNumeroControl'])->name('retenciones.nro-control');

    Route::resource('/reportes', ReportesController::class);
    Route::get('retencion-pdf/{id}', [ReportesController::class, 'retencionPdf'])->name('retencionPdf');
});
