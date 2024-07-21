<?php

use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Api\RetencionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/retenciones', [RetencionController::class, 'index'])->name('api.retencion.index');
Route::post('/retenciones-store', [RetencionController::class, 'store'])->name('api.retencion.store');
Route::get('/get-empresas/{id}', [RetencionController::class, 'getEmpresas'])->name('api.retencion.get-empresas');
Route::get('/get-cliente/{rif}', [RetencionController::class, 'getCliente'])->name('api.retencion.get-cliente');
Route::post('/nro-factura', [RetencionController::class, 'validarNumeroFactura'])->name('api.retencion.nro-factura');
Route::post('/nro-control', [RetencionController::class, 'validarNumeroControl'])->name('api.retencion.nro-control');
Route::get('/retenciones-get/{factura}', [RetencionController::class, 'getRetencionFactura'])->name('api.retencion.retenciones-get');

Route::get('/empresa', [ProveedorController::class, 'getEmpresaDatos'])->name('empresa.get');

Route::get('/consulta/{rif}', [ProveedorController::class, 'consulta_rif'])->name('proveedor.consulta-rif');
Route::post('/proveedor-store', [ProveedorController::class, 'store'])->name('api.proveedor.store');
Route::get('/proveedor-listar/{id}', [ProveedorController::class, 'retencion_proveedor'])->name('api.proveedor-listar');
Route::get('/proveedor-lista', [ProveedorController::class, 'listar'])->name('api.proveedor-lista');
