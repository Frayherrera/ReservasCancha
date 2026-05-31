<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    // Definimos las propiedades que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'horario_id',
        'precio_id',
        'estado',
    ];

    /**
     * Relación con el modelo User (Un usuario tiene muchas reservas).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo Horario (Cada reserva tiene un horario específico).
     */
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    /**
     * Relación con el modelo Precio (Cada reserva se asocia a un precio).
     */
    public function precio()
    {
        return $this->belongsTo(Precio::class);
    }
}
