<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sala_pelicula', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sala_id');
            $table->unsignedBigInteger('pelicula_id');
            $table->datetime('fecha_hora');
            $table->timestamps();

            $table->foreign('sala_id')->references('id')->on('salas')->onDelete('cascade');
            $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sala_pelicula');
    }
};
