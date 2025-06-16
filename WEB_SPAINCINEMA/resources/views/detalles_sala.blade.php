@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalles de la Sala</h1>

        <table class="table">
            <tr>
                <th>Número de la Sala</th>
                <td>{{ $sala->numero }}</td>
            </tr>
            <tr>
                <th>Capacidad</th>
                <td>{{ $sala->capacidad }}</td>
            </tr>
            <tr>
                <th>Cine</th>
                <td>{{ $sala->cine->nombre }}</td>
            </tr>
        </table>

        <a href="{{ route('salas.mostrarTodas') }}" class="btn btn-primary">Volver al Listado de Salas</a>
    </div>
@endsection
