<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sala_pelicula_id'); // Relación directa con sala_pelicula
            $table->integer('numero'); // Número del asiento
            $table->timestamps();

            // Llave foránea hacia sala_pelicula
            $table->foreign('sala_pelicula_id')->references('id')->on('sala_pelicula')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asientos');
    }
};