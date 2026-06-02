<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Reserva;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pago::with('reserva.user', 'reserva.horario');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('metodo')) {
            $query->where('metodo_pago', $request->metodo);
        }

        $pagos = $query->orderByDesc('created_at')->paginate(15);

        $resumen = [
            'total' => Pago::count(),
            'pagados' => Pago::where('estado', 'Pagado')->sum('monto'),
            'pendientes' => Pago::where('estado', 'Pendiente')->count(),
            'contador_pagados' => Pago::where('estado', 'Pagado')->count(),
        ];

        $reservasSinPago = Reserva::with('user', 'horario', 'precio')
            ->where('estado', 'Aprobada')
            ->whereDoesntHave('pagoAprobado')
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        return view('admin.pagos.index', compact('pagos', 'resumen', 'reservasSinPago'));
    }

    public function create()
    {
        $reservas = Reserva::with('user', 'horario', 'precio')
            ->whereIn('estado', ['Aprobada', 'Pendiente'])
            ->whereDoesntHave('pagoAprobado')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.pagos.create', compact('reservas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'monto' => 'required|numeric|min:0',
            'metodo_pago' => 'required|in:Efectivo,Transferencia,Tarjeta,Pago en línea,Otro',
            'referencia' => 'nullable|string|max:255',
            'estado' => 'required|in:Pendiente, Pagado,Cancelado',
        ]);

        Pago::create([
            'reserva_id' => $request->reserva_id,
            'monto' => $request->monto,
            'metodo_pago' => $request->metodo_pago,
            'referencia' => $request->referencia,
            'estado' => $request->estado,
            'fecha_pago' => $request->estado === 'Pagado' ? now() : null,
        ]);

        return redirect()->route('admin.pagos.index')->with('success', 'Pago registrado exitosamente.');
    }

    public function edit(Pago $pago)
    {
        $pago->load('reserva.user', 'reserva.horario');
        return view('admin.pagos.edit', compact('pago'));
    }

    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente, Pagado,Cancelado,Reembolsado',
            'metodo_pago' => 'required|in:Efectivo,Transferencia,Tarjeta,Pago en línea,Otro',
            'referencia' => 'nullable|string|max:255',
        ]);

        $data = [
            'estado' => $request->estado,
            'metodo_pago' => $request->metodo_pago,
            'referencia' => $request->referencia,
        ];

        if ($request->estado === 'Pagado' && !$pago->fecha_pago) {
            $data['fecha_pago'] = now();
        }

        $pago->update($data);

        return redirect()->route('admin.pagos.index')->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return back()->with('success', 'Pago eliminado.');
    }

    public function marcarPagado(Pago $pago)
    {
        $pago->update([
            'estado' => 'Pagado',
            'fecha_pago' => now(),
        ]);

        return back()->with('success', 'Pago marcado como pagado.');
    }
}
