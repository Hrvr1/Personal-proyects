@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
@endsection
@section('title', 'Lista de Salas')
@section('content')
    <section class="usuarios-container container-fluid">
        <h1 class="text-center">Listado de Salas</h1>
        <form method="GET" action="{{ route('salas.index') }}" class="row mb-4" id="filtro-cine-form">
            <div class="col-md-6 offset-md-3 mb-3">
                <select name="cine_id" class="form-select" onchange="document.getElementById('filtro-cine-form').submit()">
                    <option value="">-- Todos los cines --</option>
                    @foreach($allCines as $cineItem)
                        <option value="{{ $cineItem->id }}" {{ request('cine_id') == $cineItem->id ? 'selected' : '' }}>
                            {{ $cineItem->localidad }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 text-center mt-3 mt-md-0">
                <a href="{{ route('salas.create') }}" class="btn btn-primary admin-btn">Crear Nueva Sala</a>
            </div>
        </form>
        @if($cines->count())
            @foreach($cines as $cine)
                <div class="mb-5">
                    <h3 class="mb-3"><strong>{{ $cine->localidad }}</strong></h3>
                    @if($cine->salas->count())
                        <div class="table-responsive">
                            <table class="usuarios-table tabla-salas-ajustada table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Capacidad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cine->salas as $sala)
                                        <tr>
                                            <td>{{ $sala->numero }}</td>
                                            <td>{{ $sala->capacidad }}</td>
                                            <td>
                                                <a href="{{ route('salas.edit', $sala->id) }}"
                                                    class="btn btn-warning usuarios-btn usuarios-btn-warning">Editar</a>
                                                <form action="{{ route('salas.destroy', $sala->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger usuarios-btn usuarios-btn-danger"
                                                        onclick="return confirm('¿Estás seguro de eliminar esta sala?')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No hay salas para este cine.</p>
                    @endif
                </div>
            @endforeach
            <div class="paginacion">
                {{ $cines->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @else
            <p class="text-center">No hay cines para mostrar.</p>
        @endif

    </section>
@endsection