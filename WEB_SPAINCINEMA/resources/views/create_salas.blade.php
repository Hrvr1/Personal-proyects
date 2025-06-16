@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cines.css') }}">
@endsection

@section('content')
<div class="cine-container">
    <h1>Crear Sala</h1>
    <form action="{{ route('salas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="numero" class="form-label">Número de Sala</label>
            <input type="number" name="numero" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" name="capacidad" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cine_id" class="form-label">Seleccionar Cine</label>
            <select name="cine_id" class="form-select" required>
                <option value="">-- Selecciona un cine --</option>
                @foreach($cines as $cine)
                    <option value="{{ $cine->id }}" {{ old('cine_id') == $cine->id ? 'selected' : '' }}>
                        {{ $cine->nombre }} ({{ $cine->localidad }})
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-guardar-cambios">Guardar</button>
        <a href="{{ route('salas.index') }}" class="btn-volver w-100">Cancelar</a>
    </form>
</div>
@endsection
