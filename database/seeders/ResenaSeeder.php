<?php

namespace Database\Seeders;

use App\Models\Resena;
use App\Models\Reserva;
use App\Models\Horario;
use App\Models\Precio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResenaSeeder extends Seeder
{
    public function run()
    {
        $cliente = User::where('email', 'daniel@gmail.com')->first();
        if (!$cliente) {
            $cliente = User::create([
                'name' => 'Daniel',
                'email' => 'daniel@gmail.com',
                'password' => Hash::make('123456789'),
            ])->assignRole('cliente');
        }

        $admin = User::where('email', 'maza@gmail.com')->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Carlos Maza',
                'email' => 'maza@gmail.com',
                'password' => Hash::make('123456789'),
            ])->assignRole('administrador');
        }

        $precio = Precio::first() ?? Precio::create(['valor' => 60000]);

        $reservasConResena = Reserva::whereHas('resena')->pluck('id')->toArray();

        $horariosData = [
            ['fecha' => now()->subDays(10)->format('Y-m-d'), 'hora' => '10:00:00'],
            ['fecha' => now()->subDays(8)->format('Y-m-d'), 'hora' => '14:00:00'],
            ['fecha' => now()->subDays(5)->format('Y-m-d'), 'hora' => '16:00:00'],
            ['fecha' => now()->subDays(3)->format('Y-m-d'), 'hora' => '12:00:00'],
        ];

        $comentarios = [
            ['puntuacion' => 5, 'comentario' => 'Excelente cancha, muy bien mantenida. El pasto sintético está en perfectas condiciones. Volveremos sin duda.'],
            ['puntuacion' => 4, 'comentario' => 'Muy buena experiencia, las instalaciones son cómodas y bien iluminadas. El único pero es que faltaban más estacionamientos.'],
            ['puntuacion' => 5, 'comentario' => 'La mejor cancha de la zona. Los camarines están impecables y el servicio de atención al cliente es espectacular.'],
            ['puntuacion' => 4, 'comentario' => 'Buen lugar para jugar fútbol. El precio es justo por la calidad que ofrecen. Recomendado.'],
            ['puntuacion' => 3, 'comentario' => 'La cancha está bien, pero llegaron unos minutos atrasados a abrirnos. Igual pudimos jugar nuestro partido completo.'],
            ['puntuacion' => 5, 'comentario' => 'Increíble experiencia. Cancha de primer nivel, iluminación perfecta para partidos nocturnos. Muy recomendable.'],
            ['puntuacion' => 4, 'comentario' => 'Buena atención y buenas instalaciones. El sistema de reserva es muy fácil de usar.'],
        ];

        foreach ($horariosData as $i => $data) {
            $horario = Horario::firstOrCreate(
                ['fecha' => $data['fecha'], 'hora' => $data['hora']],
                ['estado' => 'disponible']
            );

            $reserva = Reserva::firstOrCreate(
                [
                    'user_id' => $cliente->id,
                    'horario_id' => $horario->id,
                ],
                [
                    'precio_id' => $precio->id,
                    'estado' => 'Aprobada',
                ]
            );

            if (!in_array($reserva->id, $reservasConResena)) {
                $reviewData = $comentarios[$i % count($comentarios)];
                Resena::create([
                    'user_id' => $cliente->id,
                    'reserva_id' => $reserva->id,
                    'puntuacion' => $reviewData['puntuacion'],
                    'comentario' => $reviewData['comentario'],
                ]);
            }
        }
    }
}
