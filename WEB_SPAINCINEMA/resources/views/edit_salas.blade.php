@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cines.css') }}">
@endsection

@section('content')
<div class="cine-container">
    <h1>Editar Sala</h1>
    <form action="{{ route('salas.update', $sala->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" name="capacidad" class="form-control" value="{{ $sala->capacidad }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('salas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
