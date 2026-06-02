<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['fecha', 'hora', 'estado'];

    protected $casts = [
        'fecha' => 'date:Y-m-d',
        'hora' => 'string',
    ];

    public function reserva()
    {
        return $this->hasOne(Reserva::class)->where('estado', 'Aprobada');
    }
}
