<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cine_id');
            $table->string('tipo');
            $table->string('nombre');
            $table->string('correo');
            $table->string('telefono')->nullable();
            $table->text('mensaje');
            $table->text('respuesta')->nullable();
            $table->boolean('leida')->default(false);
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('cine_id')->references('id')->on('cines')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('notificaciones');
        Schema::enableForeignKeyConstraints();
    }
};
