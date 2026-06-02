<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $ingresosMensuales = Reserva::where('reservas.estado', 'Aprobada')
            ->whereYear('reservas.created_at', $year)
            ->whereMonth('reservas.created_at', $month)
            ->join('precios', 'reservas.precio_id', '=', 'precios.id')
            ->sum('precios.valor');

        $totalReservasMes = Reserva::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        $reservasPagadas = Reserva::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('estado', 'Aprobada')
            ->count();

        $reservasPendientes = Reserva::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('estado', 'Pendiente')
            ->count();

        $ingresosPorMes = Reserva::select(
                DB::raw('YEAR(reservas.created_at) as anio'),
                DB::raw('MONTH(reservas.created_at) as mes'),
                DB::raw('SUM(precios.valor) as total')
            )
            ->where('reservas.estado', 'Aprobada')
            ->whereYear('reservas.created_at', $year)
            ->join('precios', 'reservas.precio_id', '=', 'precios.id')
            ->groupBy('anio', 'mes')
            ->orderBy('mes')
            ->get()
            ->keyBy('mes');

        $ingresosAnuales = [];
        for ($m = 1; $m <= 12; $m++) {
            $ingresosAnuales[] = $ingresosPorMes->has($m) ? (int) $ingresosPorMes[$m]->total : 0;
        }

        $ultimosPagos = Reserva::with('user', 'horario', 'precio')
            ->where('estado', 'Aprobada')
            ->orderByDesc('updated_at')
            ->take(15)
            ->get();

        $yearsDisponibles = Reserva::select(DB::raw('YEAR(created_at) as anio'))
            ->distinct()
            ->orderByDesc('anio')
            ->pluck('anio');

        return view('admin.finances.index', compact(
            'ingresosMensuales',
            'totalReservasMes',
            'reservasPagadas',
            'reservasPendientes',
            'ingresosAnuales',
            'year',
            'month',
            'ultimosPagos',
            'yearsDisponibles'
        ));
    }

    public function exportPdf(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $reservas = Reserva::with('user', 'horario', 'precio')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at')
            ->get();

        $total = $reservas->where('estado', 'Aprobada')->sum(function ($r) {
            return $r->precio->valor;
        });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.finances.pdf', compact(
            'reservas', 'total', 'year', 'month'
        ));

        return $pdf->download("reporte-{$year}-{$month}.pdf");
    }

    public function exportCsv(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $reservas = Reserva::with('user', 'horario', 'precio')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at')
            ->get();

        $filename = "reporte-{$year}-{$month}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($reservas) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Cliente', 'Email', 'Fecha', 'Hora', 'Estado', 'Monto', 'Creada']);

            foreach ($reservas as $r) {
                fputcsv($handle, [
                    $r->id,
                    $r->user->name,
                    $r->user->email,
                    $r->horario->fecha,
                    $r->horario->hora,
                    $r->estado,
                    $r->precio->valor,
                    $r->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
