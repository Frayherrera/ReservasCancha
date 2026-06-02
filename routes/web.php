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

// Rutas de horarios (públicas: solo ver)
Route::resource('horarios', HorarioController::class)->only(['index', 'show']);

// Rutas de horarios (solo admin: crear, editar, eliminar)
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::get('/horarios/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::get('/horarios/ir', [HorarioController::class, 'ir'])->name('horarios.ir');
    Route::post('/horarios', [HorarioController::class, 'store'])->name('horarios.store');
    Route::get('/horarios/{horario}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
    Route::put('/horarios/{horario}', [HorarioController::class, 'update'])->name('horarios.update');
    Route::delete('/horarios/{horario}', [HorarioController::class, 'destroy'])->name('horarios.destroy');
});

// Rutas para gestionar reservas
Route::post('/reservas', [ReservaController::class, 'store'])->middleware('auth')->name('reservas.store');
Route::get('/admin/reservas', [ReservaController::class, 'index'])->name('reservas.index');
Route::post('/admin/reservas/{id}/aprobar', [ReservaController::class, 'aprobar'])->name('reservas.aprobar');
Route::post('/admin/reservas/{id}/rechazar', [ReservaController::class, 'rechazar'])->name('reservas.rechazar');
Route::delete('admin/reservas/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');


Route::get('/usuario/editar', [UserController::class, 'edit'])->name('user.edit');
Route::put('/usuario/actualizar', [UserController::class, 'update'])->name('user.update');

Route::middleware(['auth', 'role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/usuarios', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::post('/usuarios/{user}/block', [App\Http\Controllers\Admin\UserController::class, 'block'])->name('users.block');
    Route::post('/usuarios/{user}/role', [App\Http\Controllers\Admin\UserController::class, 'changeRole'])->name('users.changeRole');
});
