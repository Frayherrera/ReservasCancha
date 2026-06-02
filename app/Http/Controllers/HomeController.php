<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('administrador')) {
            return redirect()->route('admin.dashboard');
        }

        $reservasActivas = Reserva::with('horario', 'precio')
            ->where('user_id', $user->id)
            ->whereIn('estado', ['Pendiente', 'Aprobada'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $proximosPartidos = Reserva::with('horario', 'precio')
            ->where('user_id', $user->id)
            ->where('estado', 'Aprobada')
            ->whereHas('horario', function ($q) {
                $q->where('fecha', '>=', now()->toDateString());
            })
            ->orderBy('horario.fecha')
            ->orderBy('horario.hora')
            ->take(3)
            ->get();

        $totalReservas = Reserva::where('user_id', $user->id)->count();
        $reservasAprobadas = Reserva::where('user_id', $user->id)->where('estado', 'Aprobada')->count();
        $reservasPendientes = Reserva::where('user_id', $user->id)->where('estado', 'Pendiente')->count();

        return view('home', compact(
            'reservasActivas',
            'proximosPartidos',
            'totalReservas',
            'reservasAprobadas',
            'reservasPendientes'
        ));
    }
}
