<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    // Mostrar todos los horarios
    public function index()
    {
        $horarios = Horario::with(['reserva.user'])->orderBy('created_at', 'desc')->paginate(6);
        return view('horarios.index', compact('horarios'));
    }

    // Mostrar formulario para crear un horario
    public function create()
    {
        return view('horarios.create');
    }

    // Guardar el nuevo horario en la base de datos
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'hora' => 'required|string',
    //         'estado' => 'required|in:Disponible,No disponible',
    //     ]);

    //     Horario::create($request->all());

    //     return redirect()->route('horarios.index')->with('success', 'Horario creado exitosamente.');
    // }
    public function store(Request $request)
    {
        try {
            // Validación de datos
            $validated = $request->validate([
                'fecha' => 'required|date|after_or_equal:today',
                'hora_inicio' => [
                    'required',
                    'date_format:H:i',
                    function ($attribute, $value, $fail) {
                        $hora = (int) explode(':', $value)[0];
                        if ($hora < 7 || $hora > 21) {
                            $fail('La hora de inicio debe estar entre las 7:00 AM y 9:00 PM.');
                        }
                    },
                ],
                'hora_fin' => [
                    'required',
                    'date_format:H:i',
                    'after:hora_inicio',
                    function ($attribute, $value, $fail) use ($request) {
                        $hora = (int) explode(':', $value)[0];
                        $horaInicio = (int) explode(':', $request->hora_inicio)[0];

                        if ($hora < 8 || $hora > 22) {
                            $fail('La hora de fin debe estar entre las 8:00 AM y 10:00 PM.');
                        }

                        if ($hora - $horaInicio > 15) {
                            $fail('El rango máximo permitido es de 12 horas.');
                        }
                    },
                ],
                'estado' => 'required|in:Disponible,Ocupado',
            ]);

            // Extraer las horas de inicio y fin
            $horaInicio = (int) explode(':', $request->hora_inicio)[0];
            $horaFin = (int) explode(':', $request->hora_fin)[0];

            // Verificar si ya existen horarios en ese rango de fecha y hora
            $existingHorarios = Horario::where('fecha', $request->fecha)
                ->whereRaw('HOUR(hora) >= ?', [$horaInicio])
                ->whereRaw('HOUR(hora) < ?', [$horaFin])
                ->exists();

            if ($existingHorarios) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['general' => 'Ya existen horarios creados en este rango de fecha y hora.']);
            }

            // Preparar los horarios a crear
            $horarios = [];
            for ($hora = $horaInicio; $hora < $horaFin; $hora++) {
                $horarios[] = [
                    'fecha' => $request->fecha,
                    'hora' => sprintf('%02d:00:00', $hora),
                    'estado' => $request->estado,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Insertar los horarios
            Horario::insert($horarios);

            // Contar cuántos horarios se crearon
            $cantidadHorarios = count($horarios);

            return redirect()->route('horarios.index')
                ->with('success', "Se crearon {$cantidadHorarios} horarios exitosamente.");
        } catch (\Exception $e) {


            return redirect()->route('horarios.index');
        }
    }

    // Mostrar un horario específico
    public function show(Horario $horario)
    {
        return view('horarios.show', compact('horario'));
    }

    // Mostrar formulario para editar un horario
    public function edit(Horario $horario)
    {
        return view('horarios.edit', compact('horario'));
    }

    // Actualizar el horario en la base de datos
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'hora' => 'required|string',
            'estado' => 'required|in:Disponible,No disponible',
        ]);

        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente.');
    }

    // Eliminar un horario de la base de datos
    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado exitosamente.');
    }
}
