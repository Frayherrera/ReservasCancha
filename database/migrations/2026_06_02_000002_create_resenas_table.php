<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('reserva_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('puntuacion')->unsigned()->comment('1-5 estrellas');
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->unique('reserva_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('resenas');
    }
};
