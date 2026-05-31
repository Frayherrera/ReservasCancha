<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {

        $reservas = Reserva::with('user', 'horario', 'precio')
            ->orderBy('created_at', 'desc') // Ordena por fecha de creación en orden descendente
            ->paginate(5); // Muestra 10 reservas por página        
        return view('reservas.index', compact('reservas'));
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos (sin precio_id)
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Verificar si el horario aún está disponible
        $horario = Horario::find($request->horario_id);

        if (!$horario) {
            return back()->with('error', 'El horario no fue encontrado.');
        }

        if ($horario->estado !== 'Disponible') {
            return back()->with('error', 'El horario ya no está disponible.');
        }

        // Crear la reserva con estado 'Pendiente'
        Reserva::create([
            'horario_id' => $request->horario_id,
            'user_id' => $request->user_id,
            'precio_id' => 1, // Valor por defecto
            'estado' => 'Pendiente',
        ]);

        // Cambiar el estado del horario a 'No Disponible'
        $horario->update(['estado' => 'No Disponible']);

        return redirect('/horarios')->with('success', 'Reserva creada exitosamente y pendiente de aprobación.');
    }


    public function aprobar($id)
    {
        // Encuentra la reserva específica
        $reserva = Reserva::find($id);

        // Si no se encuentra la reserva, retorna un error
        if (!$reserva) {
            return back()->with('error', 'Reserva no encontrada.');
        }

        // Cambia el estado de la reserva actual a 'Aprobada'
        $reserva->update(['estado' => 'Aprobada']);

        // Cambia el estado de las demás reservas con el mismo horario_id a 'Rechazada'
        Reserva::where('horario_id', $reserva->horario_id)
            ->where('id', '!=', $reserva->id) // Excluye la reserva aprobada actual
            ->update(['estado' => 'Rechazada']);

        return back()->with('success', 'Reserva aprobada. Las demás reservas para el mismo horario han sido rechazadas.');
    }

    public function rechazar($id)
    {
        $reserva = Reserva::find($id);
        $reserva->update(['estado' => 'Rechazada']);
        $reserva->horario->update(['estado' => 'Disponible']);
        return back()->with('success', 'Reserva rechazada.');
    }

    // En el controlador de reservas
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->update(['estado' => 'Rechazada']);
        $reserva->horario->update(['estado' => 'Disponible']);
        $reserva->delete();
        return back()->with('success', 'Reserva eliminada.');
    }
}
