@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/peliculas.css') }}">
@endsection

@section('title', 'Crear Sesión de Película')

@section('content')
    @if(auth()->user()->isAdmin())
        <div class="container mt-5 editar-pelicula-container">
            <h1 class="text-center mb-4">Crear Sesión de Película</h1>
            <form method="POST" action="{{ route('admin.sesiones.guardar') }}" class="row g-3"
                onsubmit="combinarFechaHora(event)">
                @csrf

                <div class="col-12">
                    <label for="cine_id" class="form-label">Cine</label>
                    <select id="cine_id" class="form-select" required onchange="filtrarDatos(this.value)">
                        <option value="" disabled selected>Selecciona un cine</option>
                        @foreach($cines as $cine)
                            <option value="{{ $cine->id }}">{{ $cine->nombre }} - {{ $cine->localidad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="pelicula_id" class="form-label">Película</label>
                    <select name="pelicula_id" id="pelicula_id" class="form-select" required>
                        <option value="">Selecciona una película</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="sala_id" class="form-label">Sala</label>
                    <select name="sala_id" id="sala_id" class="form-select" required>
                        <option value="">Selecciona una sala</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" required>
                </div>

                <div class="col-12">
                    <label for="hora" class="form-label">Hora</label>
                    <input type="time" id="hora" name="hora" class="form-control" required>
                </div>

                <input type="hidden" name="fecha_hora" id="fecha_hora_final">

                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100">Crear Sesión</button>
                </div>
                <div class="col-12">
                    <a href="{{ route('peliculas.gestionar') }}" class="btn-volver w-100">Volver</a>
                </div>
            </form>


            <script>
                const datosPorCine = @json($datosPorCine);

                function filtrarDatos(cineId) {
                    const peliculasSelect = document.getElementById('pelicula_id');
                    const salasSelect = document.getElementById('sala_id');
                    peliculasSelect.innerHTML = '<option value="">Selecciona una película</option>';
                    salasSelect.innerHTML = '<option value="">Selecciona una sala</option>';

                    const datos = datosPorCine[cineId];

                    datos.peliculas.forEach(p => {
                        const option = document.createElement('option');
                        option.value = p.id;
                        option.text = p.nombre;
                        peliculasSelect.appendChild(option);
                    });

                    datos.salas.forEach(s => {
                        const option = document.createElement('option');
                        option.value = s.id;
                        option.text = `Sala ${s.numero}`;
                        salasSelect.appendChild(option);
                    });
                }

                function combinarFechaHora(event) {
                    const fecha = document.getElementById('fecha').value;
                    const hora = document.getElementById('hora').value;
                    const campoFinal = document.getElementById('fecha_hora_final');

                    if (fecha && hora) {
                        campoFinal.value = `${fecha}T${hora}`;
                    } else {
                        event.preventDefault();
                        alert('Debes seleccionar una fecha y una hora válidas.');
                    }
                }
            </script>
    @else
            <p class="alert alert-danger text-center">Acceso denegado. Solo los administradores pueden acceder a esta página.
            </p>
        @endif
@endsection