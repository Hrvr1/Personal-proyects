@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cines.css') }}">
@endsection

@section('title', 'Añadir Nuevo Cine')

@section('content')
    <div class="cine-container">
        <h1>Añadir Nuevo Cine</h1>
        <form action="{{ route('cines.store') }}" method="POST" class="cine-form">
            @csrf

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="SpainCinema" readonly required>

            <label for="localidad">Localidad</label>
            <input type="text" id="localidad" name="localidad" required>

            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="cantidad_salas">Cantidad de Salas</label>
            <input type="number" id="cantidad_salas" name="cantidad_salas" min="1" required>

            <button type="submit" class="btn-guardar-cambios">Crear cine</button>

        </form>
        <a href="{{ route('cines.index') }}" class="btn-volver w-100">Volver</a>
    </div>
@endsection