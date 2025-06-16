
@extends('layouts.master')

@section('title', 'Lista de Usuarios')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">  
@endsection

@section('content')
    <section class="usuarios-container container-fluid">
        <h1 class="text-center">Lista de Usuarios</h1>
        @if ($usuarios->isEmpty())
            <p class="text-center">No hay usuarios registrados.</p>
        @else
            <div class="actions-container row mb-4">
                <div class="col-md-12 d-flex justify-content-center">
                    <form method="GET" action="{{ route('usuarios.index') }}" class="search-form d-flex">
                        <input type="text" name="nombre" class="form-control me-2" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </form>
                </div>
                <div class="col-md-12 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.create') }}" class="btn btn-primary admin-btn">Crear Nuevo Administrador</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="usuarios-table table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                        <tr class="clickable-row" data-href="{{ route('usuarios.show', $usuario->id) }}">
                                <td>{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->apellidos }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning usuarios-btn usuarios-btn-warning">Editar</a>
                                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger usuarios-btn usuarios-btn-danger"
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Borrar</button>
                                    </form>
                                    @if (!$usuario->isAdmin())
                                        <form action="{{ route('admin.asignarAdmin', $usuario->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-info usuarios-btn usuarios-btn-admin"
                                                onclick="return confirm('¿Estás seguro de que deseas asignar este usuario como administrador?')">Asignar Admin</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger usuarios-btn usuarios-btn-danger"
                                                onclick="return confirm('¿Estás seguro de que deseas desasignar el rol de administrador a este usuario?')">Quitar Admin</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="paginacion">
                {{ $usuarios->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('.clickable-row');
            rows.forEach(row => {
                row.addEventListener('click', function () {
                    window.location.href = this.dataset.href;
                });
            });
        });
    </script>
@endsection