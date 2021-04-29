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

Route::get('/', [App\Http\Controllers\ReservaController::class, 'index'])->name('reservas.index')->middleware("auth");

Auth::routes();

Route::group(['middleware' => ['auth']], function(){

Route::get('/reserva', [App\Http\Controllers\ReservaController::class, 'index'])->name('reservas.index');
Route::get('/reserva/mostrar', [App\Http\Controllers\ReservaController::class, 'show']);
Route::post('/reserva/crear', [App\Http\Controllers\ReservaController::class, 'store'])->name('reserva.store');

//para ver la gestion de salas
Route::get('salas/gestion', [App\Http\Controllers\EspacioFisicoController::class, 'management'])->name('management.index');

//para ver una fecha especifica tocando el calendario
Route::get('/salas/{date}', [App\Http\Controllers\EspacioFisicoController::class, 'index']);

Route::post('/agregaSala', [App\Http\Controllers\EspacioFisicoController::class, 'store'])->name('espacioFisico.store');
Route::get('/sala/{id}', [App\Http\Controllers\EspacioFisicoController::class, 'edit']);
Route::put('/editarSala', [App\Http\Controllers\EspacioFisicoController::class, 'update'])->name('sala.update');
Route::delete('/eliminarSala', [App\Http\Controllers\EspacioFisicoController::class, 'destroy'])->name('sala.destroy');

});