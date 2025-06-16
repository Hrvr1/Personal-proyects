@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cines.css') }}">
@endsection

@section('title', 'Cine ' . $cine->localidad)

@section('content')
    <div class="container cine-container">
        <h1 class="text-center">Películas en {{ $cine->localidad }}</h1>
        @if ($peliculas->isEmpty())
            <p class="text-center">No hay películas disponibles en este cine.</p>
        @else
            <div class="table-responsive">
                <table class="table cine-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Género</th>
                            <th>Duración</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peliculas as $pelicula)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/imagenes/' . $pelicula->imagen) }}" alt="{{ $pelicula->nombre }}"
                                        class="img-fluid pelicula-imagen">
                                </td>
                                <td>{{ $pelicula->nombre }}</td>
                                <td>{{ $pelicula->genero }}</td>
                                <td>{{ $pelicula->duracion }} min</td>
                                <td>{{ $pelicula->descripcion }}</td>
                                <td>
                                    <!-- Botón para desasociar -->
                                    <form action="{{ route('cines.desasociarPelicula') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="pelicula_id" value="{{ $pelicula->id }}">
                                        <input type="hidden" name="cine_id" value="{{ $cine->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Estás seguro de que deseas desasociar esta película del cine?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Botón Volver -->
            <div class="text-center my-3">
                <a href="{{ route('cines.index') }}" class="btn btn-secondary">Volver</a>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $peliculas->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection