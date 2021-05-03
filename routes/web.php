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

Route::group(['middleware' => ['isAdmin']], function(){
    Route::get('/reserva/mostrar', [App\Http\Controllers\ReservaController::class, 'show']);
    Route::post('/reserva/crear', [App\Http\Controllers\ReservaController::class, 'store'])->name('reserva.store');
    Route::delete('/reserva/eliminar', [App\Http\Controllers\ReservaController::class, 'destroy'])->name('reserva.destroy');

    //para ver la gestion de salas
    Route::get('salas/gestion', [App\Http\Controllers\EspacioFisicoController::class, 'management'])->name('management.index');

    //Gestion Salas
    Route::post('/agregaSala', [App\Http\Controllers\EspacioFisicoController::class, 'store'])->name('espacioFisico.store');
    //Route::get('/sala/{id}', [App\Http\Controllers\EspacioFisicoController::class, 'edit']);
    Route::get('/sala/obtener', [App\Http\Controllers\EspacioFisicoController::class, 'edit'])->name('sala.edit');
    Route::put('/editarSala', [App\Http\Controllers\EspacioFisicoController::class, 'update'])->name('sala.update');
    Route::delete('/eliminarSala', [App\Http\Controllers\EspacioFisicoController::class, 'destroy'])->name('sala.destroy');

    //Gestion de Implementos
    Route::get('/implemento/gestion', [App\Http\Controllers\ImplementosController::class, 'index'])->name('implemento.index');

    Route::get('/implemento/{id}', [App\Http\Controllers\ImplementosController::class, 'edit'])->name('implemento.edit');
    Route::get('/implemento/{id}', [App\Http\Controllers\ImplementosController::class, 'edit'])->name('implemento.edit');
    Route::post('/implemento/crear', [App\Http\Controllers\ImplementosController::class, 'store'])->name('implemento.store');
    Route::put('/implemento/editar', [App\Http\Controllers\ImplementosController::class, 'update'])->name('implemento.update');
    Route::delete('/implemento/borrar', [App\Http\Controllers\ImplementosController::class, 'destroy'])->name('implemento.destroy');

});

Route::group(['middleware' => ['auth']], function(){
    Route::get('/reserva', [App\Http\Controllers\ReservaController::class, 'index'])->name('reservas.index');
    //para ver una fecha especifica tocando el calendario
    Route::get('/salas/{date}', [App\Http\Controllers\EspacioFisicoController::class, 'index']);
    
    Route::get('/reserva/mostrar', [App\Http\Controllers\ReservaController::class, 'show']);
    Route::post('/reserva/crear', [App\Http\Controllers\ReservaController::class, 'store'])->name('reserva.store');
    Route::delete('/reserva/eliminar', [App\Http\Controllers\ReservaController::class, 'destroy'])->name('reserva.destroy');
    //Obtener Implementos de una sala
    Route::get('obtenerImplementos', [App\Http\Controllers\ImplementosDeEspacioController::class, 'show'])->name('espaciotieneimplemento.show');
});