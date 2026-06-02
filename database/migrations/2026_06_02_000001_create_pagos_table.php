<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_id')->constrained()->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->enum('metodo_pago', ['Efectivo', 'Transferencia', 'Tarjeta', 'Pago en línea', 'Otro'])->default('Efectivo');
            $table->string('referencia')->nullable();
            $table->enum('estado', ['Pendiente', 'Pagado', 'Cancelado', 'Reembolsado'])->default('Pendiente');
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
};
