@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cines.css') }}">
@endsection

@section('title', 'Asociar Película a Cine')

@section('content')
    <div class="cine-container">
        <h1>Asociar Película a Cine</h1>
        <form method="POST" action="{{ route('admin.peliculas.asociar.guardar') }}" class="cine-form">
            @csrf

            <label for="pelicula_id">Película</label>
            <select name="pelicula_id"class="form-select" required>
                @foreach($peliculas as $pelicula)
                    <option value="{{ $pelicula->id }}" {{ isset($peliculaId) && $peliculaId == $pelicula->id ? 'selected' : '' }}> {{ $pelicula->nombre }}</option>
                @endforeach
            </select>

            <label for="cine_id">Cine</label>
            <select name="cine_id"class="form-select" required>
                @foreach($cines as $cine)
                    <option value="{{ $cine->id }}">{{ $cine->nombre }} - {{ $cine->localidad }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-guardar-cambios">Asociar</button>
        </form>

        <a href="{{ route('peliculas.gestionar') }}" class="btn-volver w-100">Volver</a>
    </div>
@endsection