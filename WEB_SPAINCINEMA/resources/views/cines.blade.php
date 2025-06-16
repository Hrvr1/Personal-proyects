
@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cines.css') }}">
@endsection

@section('title', 'SpainCinema - Listado de Cines')

@section('content')
    <div class="cine-container container-fluid">
        <h1>Listado de Cines</h1>
        <form method="GET" action="{{ route('cines.index') }}" class="search-form d-flex">
            <div class="row">
                <div class="col-md-8 mb-2">
                    <input type="text" name="localidad" class="form-control me-2" placeholder="Buscar por localidad" value="{{ request('localidad') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Botón para añadir un nuevo cine -->
        <div class="text-end mb-3">
        <a href="{{ route('cines.create') }}" class="btn btn-success">Añadir Cine</a>
        </div>

        <!-- Tabla de cines -->
        <div class="table-responsive">
            <table class="table table-striped table-hover cine-table centered-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Localidad</th>
                        <th>Dirección</th>
                        <th>Cantidad de Salas</th>
                        <th>Cantidad de Películas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cines as $cine)
                        <tr data-href="{{ route('cines.peliculas', $cine->id) }}" class="clickable-row">
                            <td>{{ $cine->nombre }}</td>
                            <td>{{ $cine->localidad }}</td>
                            <td>{{ $cine->direccion }}</td>
                            <td>{{ $cine->cantidad_salas }}</td>
                            <td>{{ $cine->peliculas_count }}</td>
                            <td>
                                <a href="{{ route('cines.edit', $cine->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('cines.destroy', $cine->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este cine?')">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No se encontraron cines.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="paginacion">
            {{ $cines->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('.clickable-row');
            rows.forEach(row => {
                row.addEventListener('click', function () {
                    window.location = this.dataset.href;
                });
            });
        });
    </script>
@endsection