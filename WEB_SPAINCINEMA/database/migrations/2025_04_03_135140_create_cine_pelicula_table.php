<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cine_pelicula', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cine_id');
            $table->unsignedBigInteger('pelicula_id');
            $table->timestamps();
        
            $table->foreign('cine_id')->references('id')->on('cines')->onDelete('cascade');
            $table->foreign('pelicula_id')->references('id')->on('peliculas')->onDelete('cascade');
        
            $table->unique(['cine_id', 'pelicula_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cine_pelicula');
    }
};
