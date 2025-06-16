@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cines.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>Gestión de Salas</h1>
        <!-- Sección de creación de nueva sala -->
        <div class="mb-4">
            <h3>Crear Nueva Sala</h3>
            <form action="{{ route('salas.guardar') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="numero">Número de la Sala</label>
                    <input type="number" class="form-control" id="numero" name="numero" required>
                </div>

                <div class="form-group">
                    <label for="capacidad">Capacidad</label>
                    <input type="number" class="form-control" id="capacidad" name="capacidad" required>
                </div>

                <div class="form-group">
                    <label for="cine_id">Cine</label>
                    <select class="form-control" id="cine_id" name="cine_id" required>
                        @foreach ($cines as $cine)
                            <option value="{{ $cine->id }}">{{ $cine->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Crear Sala</button>
            </form>
        </div>

        <!-- Listado de Salas -->
        <h3>Listado de Salas</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Numero</th>
                    <th>Capacidad</th>
                    <th>Cine</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salas as $sala)
                    <tr>
                        <td>{{ $sala->id }}</td>
                        <td>{{ $sala->numero }}</td>
                        <td>{{ $sala->capacidad }}</td>
                        <td>{{ $sala->cine->nombre }}</td>
                        <td>
                            <!-- Redirigir al detalle de la sala -->
                            <a href="{{ route('salas.mostrar', $sala->id) }}" class="btn btn-info">Ver</a>
                            <a href="#sala-{{ $sala->id }}-edit" class="btn btn-warning" data-toggle="collapse">Editar</a>
                            <form action="{{ route('salas.eliminar', $sala->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>

                            <!-- Formulario de edición de sala (colapsar) -->
                            <div id="sala-{{ $sala->id }}-edit" class="collapse">
                                <form action="{{ route('salas.actualizar', $sala->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="numero">Número de la Sala</label>
                                        <input type="number" class="form-control" name="numero" value="{{ $sala->numero }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="capacidad">Capacidad</label>
                                        <input type="number" class="form-control" name="capacidad" value="{{ $sala->capacidad }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="cine_id">Cine</label>
                                        <select class="form-control" name="cine_id" required>
                                            @foreach ($cines as $cine)
                                                <option value="{{ $cine->id }}" {{ $cine->id == $sala->cine_id ? 'selected' : '' }}>
                                                    {{ $cine->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Actualizar Sala</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Página de paginación -->
        {{ $salas->links() }}
    </div>
@endsection

