<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asiento');
            $table->unsignedBigInteger('user_id');
            $table->decimal('precio', 8, 2); 
            $table->timestamp('fecha_hora'); 
            $table->unsignedBigInteger('pelicula_id');
            $table->unsignedBigInteger('sala_id'); 
            $table->string('estado'); 
            $table->timestamp('fecha_reserva_expiracion')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');
            $table->foreign('sala_id')->references('id')->on('salas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('tickets');
        Schema::enableForeignKeyConstraints();
    }
    
};
