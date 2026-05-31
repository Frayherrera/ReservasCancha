<?php

use App\Http\Controllers\HorarioController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Ruta raíz: Redirige a login si no está autenticado, sino muestra la vista welcome o home.
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Auth::routes();

// Ruta después de autenticación (HomeController)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas de horarios (CRUD)
Route::resource('horarios', HorarioController::class);

// Rutas para gestionar reservas
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
Route::get('/admin/reservas', [ReservaController::class, 'index'])->name('reservas.index');
Route::post('/admin/reservas/{id}/aprobar', [ReservaController::class, 'aprobar'])->name('reservas.aprobar');
Route::post('/admin/reservas/{id}/rechazar', [ReservaController::class, 'rechazar'])->name('reservas.rechazar');
Route::delete('admin/reservas/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');


Route::get('/usuario/editar', [UserController::class, 'edit'])->name('user.edit');
Route::put('/usuario/actualizar', [UserController::class, 'update'])->name('user.update');
