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

// Rutas de horarios (solo admin: crear, editar, eliminar)
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::get('/horarios/create', [HorarioController::class, 'create'])->name('horarios.create');
    Route::post('/horarios', [HorarioController::class, 'store'])->name('horarios.store');
    Route::get('/horarios/{horario}/edit', [HorarioController::class, 'edit'])->name('horarios.edit');
    Route::put('/horarios/{horario}', [HorarioController::class, 'update'])->name('horarios.update');
    Route::delete('/horarios/{horario}', [HorarioController::class, 'destroy'])->name('horarios.destroy');
});

// Rutas de horarios (públicas: solo ver) — deben ir DESPUÉS de rutas específicas
Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
Route::get('/horarios/{horario}', [HorarioController::class, 'show'])->name('horarios.show');

// Rutas para gestionar reservas
Route::post('/reservas', [ReservaController::class, 'store'])->middleware('auth')->name('reservas.store');
Route::get('/admin/reservas', [ReservaController::class, 'index'])->name('reservas.index');
Route::post('/admin/reservas/{id}/aprobar', [ReservaController::class, 'aprobar'])->name('reservas.aprobar');
Route::post('/admin/reservas/{id}/rechazar', [ReservaController::class, 'rechazar'])->name('reservas.rechazar');
Route::delete('admin/reservas/{id}', [ReservaController::class, 'destroy'])->name('reservas.destroy');
Route::post('/admin/reservas/{id}/reagendar', [ReservaController::class, 'reagendar'])->middleware('auth', 'role:administrador')->name('reservas.reagendar');

Route::post('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar'])->middleware('auth')->name('reservas.cancelar');
Route::get('/horarios-disponibles', [ReservaController::class, 'horariosDisponibles'])->middleware('auth')->name('horarios.disponibles');
Route::get('/reservas/{id}', [ReservaController::class, 'show'])->name('reservas.show');

Route::get('/resenas', [App\Http\Controllers\ResenaController::class, 'index'])->name('resenas.index');
Route::get('/resenas/crear/{reserva}', [App\Http\Controllers\ResenaController::class, 'create'])->middleware('auth')->name('resenas.create');
Route::post('/resenas', [App\Http\Controllers\ResenaController::class, 'store'])->middleware('auth')->name('resenas.store');
Route::delete('/resenas/{resena}', [App\Http\Controllers\ResenaController::class, 'destroy'])->middleware('auth')->name('resenas.destroy');

Route::get('/reservas/{id}/qr', [App\Http\Controllers\ReservaController::class, 'showQr'])->middleware('auth')->name('reservas.qr');


Route::get('/usuario/editar', [UserController::class, 'edit'])->name('user.edit');
Route::put('/usuario/actualizar', [UserController::class, 'update'])->name('user.update');

Route::middleware(['auth', 'role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/usuarios', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/usuarios/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::post('/usuarios/{user}/block', [App\Http\Controllers\Admin\UserController::class, 'block'])->name('users.block');
    Route::post('/usuarios/{user}/role', [App\Http\Controllers\Admin\UserController::class, 'changeRole'])->name('users.changeRole');

    Route::get('/finanzas', [App\Http\Controllers\Admin\FinancialController::class, 'index'])->name('finances.index');
    Route::get('/finanzas/pdf', [App\Http\Controllers\Admin\FinancialController::class, 'exportPdf'])->name('finances.pdf');
    Route::get('/finanzas/csv', [App\Http\Controllers\Admin\FinancialController::class, 'exportCsv'])->name('finances.csv');

    Route::get('/pagos', [App\Http\Controllers\Admin\PagoController::class, 'index'])->name('pagos.index');
    Route::get('/pagos/crear', [App\Http\Controllers\Admin\PagoController::class, 'create'])->name('pagos.create');
    Route::post('/pagos', [App\Http\Controllers\Admin\PagoController::class, 'store'])->name('pagos.store');
    Route::get('/pagos/{pago}/editar', [App\Http\Controllers\Admin\PagoController::class, 'edit'])->name('pagos.edit');
    Route::put('/pagos/{pago}', [App\Http\Controllers\Admin\PagoController::class, 'update'])->name('pagos.update');
    Route::delete('/pagos/{pago}', [App\Http\Controllers\Admin\PagoController::class, 'destroy'])->name('pagos.destroy');
    Route::post('/pagos/{pago}/marcar-pagado', [App\Http\Controllers\Admin\PagoController::class, 'marcarPagado'])->name('pagos.marcarPagado');
});
