<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $reservasDelDia = Reserva::whereDate('created_at', today())->count();

        $gananciasSemanales = Reserva::where('reservas.estado', 'Aprobada')
            ->whereBetween('reservas.created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->join('precios', 'reservas.precio_id', '=', 'precios.id')
            ->sum('precios.valor');

        $horariosMasSolicitados = Reserva::select('horarios.hora', DB::raw('count(*) as total'))
            ->join('horarios', 'reservas.horario_id', '=', 'horarios.id')
            ->where('reservas.estado', 'Aprobada')
            ->groupBy('horarios.hora')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $usuariosRegistrados = User::count();

        $totalReservas = Reserva::count();
        $reservasAprobadas = Reserva::where('estado', 'Aprobada')->count();
        $reservasPendientes = Reserva::where('estado', 'Pendiente')->count();
        $reservasRechazadas = Reserva::where('estado', 'Rechazada')->count();

        $ultimasReservas = Reserva::with('user', 'horario', 'precio')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $reservasPorDia = Reserva::select(DB::raw('DATE(created_at) as fecha'), DB::raw('count(*) as total'))
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $topUsuarios = User::withCount(['reservas' => function ($q) {
            $q->where('estado', 'Aprobada');
        }])->orderByDesc('reservas_count')->take(5)->get();

        return view('admin.dashboard', compact(
            'reservasDelDia',
            'gananciasSemanales',
            'horariosMasSolicitados',
            'usuariosRegistrados',
            'totalReservas',
            'reservasAprobadas',
            'reservasPendientes',
            'reservasRechazadas',
            'ultimasReservas',
            'reservasPorDia',
            'topUsuarios'
        ));
    }
}
