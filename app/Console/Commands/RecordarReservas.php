<?php

namespace App\Console\Commands;

use App\Jobs\EnviarConfirmacionReserva;
use App\Mail\RecordatorioPartido;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RecordarReservas extends Command
{
    protected $signature = 'reservas:recordatorios';
    protected $description = 'Envía recordatorios de partidos para el día siguiente';

    public function handle()
    {
        $manana = Carbon::tomorrow()->toDateString();

        $reservas = Reserva::with('user', 'horario', 'precio')
            ->where('estado', 'Aprobada')
            ->whereHas('horario', function ($query) use ($manana) {
                $query->where('fecha', $manana);
            })
            ->get();

        $count = 0;
        foreach ($reservas as $reserva) {
            Mail::to($reserva->user->email)
                ->send(new RecordatorioPartido($reserva));
            $count++;
        }

        $this->info("Se enviaron {$count} recordatorios para el día {$manana}.");
    }
}
