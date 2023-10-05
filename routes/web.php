<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\HomeController;
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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');



    Route::resource('/clientes', ClientesController::class);
    Route::post('/clientes/consulta', [ClientesController::class, 'consulta_rif'])->name('clientes.consulta');

    Route::resource('/retenciones', RetencionController::class);

    Route::resource('/reportes', ReportesController::class);
    Route::get('retencion-pdf/{id}', [ReportesController::class, 'retencionPdf'])->name('retencionPdf');
});
