<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarConfirmacionReserva;
use App\Jobs\EnviarNotificacionCancelacion;
use App\Models\Horario;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $query = Reserva::with('user', 'horario', 'precio');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha')) {
            $query->whereHas('horario', function ($q) use ($request) {
                $q->where('fecha', $request->fecha);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $reservas = $query->orderBy('created_at', 'desc')->paginate(10);

        $resumen = [
            'total' => Reserva::count(),
            'pendientes' => Reserva::where('estado', 'Pendiente')->count(),
            'aprobadas' => Reserva::where('estado', 'Aprobada')->count(),
            'rechazadas' => Reserva::where('estado', 'Rechazada')->count(),
        ];

        return view('reservas.index', compact('reservas', 'resumen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
        ]);

        $horario = Horario::findOrFail($request->horario_id);

        if ($horario->fecha < now()->toDateString()) {
            return back()->with('error', 'No puedes reservar un horario pasado.');
        }

        $updated = Horario::where('id', $request->horario_id)
            ->where('estado', 'Disponible')
            ->update(['estado' => 'No Disponible']);

        if ($updated === 0) {
            return back()->with('error', 'El horario ya no está disponible.');
        }

        $reserva = Reserva::create([
            'horario_id' => $request->horario_id,
            'user_id' => auth()->id(),
            'precio_id' => 1,
            'estado' => 'Pendiente',
        ]);

        EnviarConfirmacionReserva::dispatch($reserva);

        return redirect('/horarios')->with('success', 'Reserva creada exitosamente y pendiente de aprobación.');
    }

    public function aprobar($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->horario->fecha < now()->toDateString()) {
            return back()->with('error', 'No puedes aprobar una reserva con fecha pasada.');
        }

        $reserva->update(['estado' => 'Aprobada']);

        Reserva::where('horario_id', $reserva->horario_id)
            ->where('id', '!=', $reserva->id)
            ->update(['estado' => 'Rechazada']);

        EnviarConfirmacionReserva::dispatch($reserva);

        return back()->with('success', 'Reserva aprobada. Las demás reservas para el mismo horario han sido rechazadas.');
    }

    public function rechazar($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update(['estado' => 'Rechazada']);

        $otraAprobada = Reserva::where('horario_id', $reserva->horario_id)
            ->where('estado', 'Aprobada')
            ->exists();

        if (!$otraAprobada) {
            $reserva->horario->update(['estado' => 'Disponible']);
        }

        EnviarNotificacionCancelacion::dispatch($reserva);

        return back()->with('success', 'Reserva rechazada.');
    }

    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update(['estado' => 'Rechazada']);

        $otraAprobada = Reserva::where('horario_id', $reserva->horario_id)
            ->where('estado', 'Aprobada')
            ->exists();

        if (!$otraAprobada) {
            $reserva->horario->update(['estado' => 'Disponible']);
        }

        $reserva->delete();
        return back()->with('success', 'Reserva eliminada.');
    }

    public function cancelar($id)
    {
        $reserva = Reserva::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('estado', 'Pendiente')
            ->firstOrFail();

        $reserva->update(['estado' => 'Rechazada']);
        $reserva->horario->update(['estado' => 'Disponible']);

        EnviarNotificacionCancelacion::dispatch($reserva);

        return back()->with('success', 'Reserva cancelada exitosamente.');
    }

    public function reagendar(Request $request, $id)
    {
        $request->validate([
            'nuevo_horario_id' => 'required|exists:horarios,id',
        ]);

        $reserva = Reserva::findOrFail($id);

        if (!in_array($reserva->estado, ['Pendiente', 'Aprobada'])) {
            return back()->with('error', 'Solo se pueden reagendar reservas pendientes o aprobadas.');
        }

        $nuevoHorario = Horario::findOrFail($request->nuevo_horario_id);

        if ($nuevoHorario->estado !== 'Disponible') {
            return back()->with('error', 'El nuevo horario no está disponible.');
        }

        if ($nuevoHorario->fecha < now()->toDateString()) {
            return back()->with('error', 'No puedes reagendar a una fecha pasada.');
        }

        $horarioAnterior = $reserva->horario;

        $nuevoHorario->update(['estado' => 'No Disponible']);
        $reserva->update(['horario_id' => $nuevoHorario->id]);

        $otraAprobada = Reserva::where('horario_id', $horarioAnterior->id)
            ->where('estado', 'Aprobada')
            ->exists();

        if (!$otraAprobada) {
            $horarioAnterior->update(['estado' => 'Disponible']);
        }

        return back()->with('success', 'Reserva reagendada exitosamente.');
    }

    public function show($id)
    {
        $reserva = Reserva::with('user', 'horario', 'precio', 'pagos', 'resena')->findOrFail($id);
        return view('reservas.show', compact('reserva'));
    }

    public function horariosDisponibles()
    {
        $horarios = Horario::where('fecha', '>=', now()->toDateString())
            ->where('estado', 'Disponible')
            ->orderBy('fecha')
            ->orderBy('hora')
            ->get(['id', 'fecha', 'hora']);

        return response()->json($horarios);
    }

    public function showQr($id)
    {
        $reserva = Reserva::with('user', 'horario', 'precio')->findOrFail($id);

        if (!auth()->user()->hasRole('administrador') && $reserva->user_id !== auth()->id()) {
            return back()->with('error', 'No tienes permiso para ver este código QR.');
        }

        $qrData = route('reservas.show', $reserva->id);
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qrData);

        return view('reservas.qr', compact('reserva', 'qrUrl'));
    }
}
