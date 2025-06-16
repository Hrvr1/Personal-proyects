@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cines.css') }}">
    <link rel="stylesheet" href="{{ asset('css/peliculas.css') }}">
@endsection

@section('title', 'Gestionar Películas')

@section('content')
    @if(auth()->user()->isAdmin())
        <div class="container cine-container">
            <h1 class="text-center">Gestión de Películas</h1>
            <form action="{{ route('peliculas.index') }}" method="GET" class="row g-3 mb-4">
                {{-- Buscador por nombre --}}
                <div class="col-md-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Buscar por película..."
                        value="{{ request('nombre') }}">
                </div>

                {{-- Filtro por género --}}
                <div class="col-md-3">
                    <select name="genero" class="form-select">
                        <option value="">Todos los géneros</option>
                        @foreach($generos as $genero)
                            <option value="{{ $genero }}" {{ request('genero') == $genero ? 'selected' : '' }}>{{ $genero }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Ordenar por fecha de estreno --}}
                <div class="col-md-3">
                    <select name="ordenar" class="form-select">
                        <option value="">Ordenar por</option>
                        <option value="asc" {{ request('ordenar') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ request('ordenar') == 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>
                </div>

                {{-- Botón de aplicar filtros --}}
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
                </div>
            </form>

            <div class="mb-3 text-end">
                <a href="{{ route('peliculas.create') }}" class="btn btn-success">Añadir Nueva Película</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Género</th>
                            <th>Duración</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peliculas as $pelicula)
                            <tr id="pelicula-{{ $pelicula->id }}">
                                <td>
                                    <img src="{{ asset('storage/imagenes/' . $pelicula->imagen) }}" alt="{{ $pelicula->nombre }}"
                                        class="img-fluid gestionar-pelicula-imagen">
                                </td>
                                <td>{{ $pelicula->nombre }}</td>
                                <td>{{ $pelicula->genero }}</td>
                                <td>{{ $pelicula->duracion }} min</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('peliculas.edit', $pelicula->id) }}"
                                            class="btn btn-warning btn-sm">Editar</a>
                                        <a href="{{ route('admin.peliculas.asociar', $pelicula->id) }}"
                                            class="btn btn-info btn-sm">Asociar a Cine</a>
                                        <form action="{{ route('peliculas.destroy', $pelicula->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Seguro que deseas eliminar esta película?')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No se encontraron películas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $peliculas->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    @else
        <div class="alert alert-danger">Acceso denegado. Solo los administradores pueden acceder a esta página.</div>
    @endif
@endsection