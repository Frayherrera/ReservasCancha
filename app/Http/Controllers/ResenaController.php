<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ResenaController extends Controller
{
    public function index()
    {
        $resenas = Resena::with('user', 'reserva.horario')
            ->orderByDesc('created_at')
            ->paginate(15);

        $promedio = Resena::avg('puntuacion');
        $total = Resena::count();

        return view('resenas.index', compact('resenas', 'promedio', 'total'));
    }

    public function create(Reserva $reserva)
    {
        if ($reserva->user_id !== auth()->id()) {
            return back()->with('error', 'No puedes calificar una reserva que no es tuya.');
        }

        if ($reserva->estado !== 'Aprobada') {
            return back()->with('error', 'Solo puedes calificar reservas aprobadas.');
        }

        if ($reserva->resena) {
            return back()->with('error', 'Ya calificaste esta reserva.');
        }

        return view('resenas.create', compact('reserva'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reserva_id' => 'required|exists:reservas,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);

        $reserva = Reserva::findOrFail($request->reserva_id);

        if ($reserva->user_id !== auth()->id()) {
            return back()->with('error', 'No puedes calificar una reserva que no es tuya.');
        }

        Resena::create([
            'user_id' => auth()->id(),
            'reserva_id' => $request->reserva_id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('resenas.index')->with('success', 'Gracias por tu calificación.');
    }

    public function destroy(Resena $resena)
    {
        if ($resena->user_id !== auth()->id() && !auth()->user()->hasRole('administrador')) {
            return back()->with('error', 'No tienes permiso para eliminar esta calificación.');
        }

        $resena->delete();
        return back()->with('success', 'Calificación eliminada.');
    }
}
