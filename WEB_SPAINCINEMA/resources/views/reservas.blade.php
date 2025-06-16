@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reservas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tickets.css') }}">
@endsection
@section('title', 'Mis Reservas')

@section('content')
    <section class="mis-tickets container">
        <h1 class="tickets-title text-center my-4">Mis Reservas</h1>
        <a href="{{ route('tickets.index') }}" class="btn btn-primary mb-4">
            <i class="fas fa-ticket-alt"></i> Tickets
        </a>
        @if($reservas->isEmpty())
            <p class="text-center">No tienes ninguna reserva activa.</p>
        @else
            <div class="d-flex justify-content-center mb-4">
                <form method="GET" action="{{ route('tickets.reservados') }}"
                    class="d-flex flex-wrap gap-2 justify-content-center">
                    {{-- Buscador por película --}}
                    <input type="text" name="pelicula" placeholder="Buscar por película" value="{{ request('pelicula') }}"
                        class="form-control me-2">

                    {{-- Ordenar por fecha --}}
                    <select name="ordenar" class="form-select me-2">
                        <option value="">Ordenar por</option>
                        <option value="asc" {{ request('ordenar') === 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ request('ordenar') === 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>

                    <button type="submit" name="ordenar" value="fecha" class="btn btn-secondary me-2">Ordenar por Fecha</button>
                    {{-- Botón de aplicar filtros --}}
                    <button type="submit" class="btn btn-success">Aplicar Filtros</button>
                </form>
            </div>

            <div class="row g-4">
                @foreach($reservas as $reserva)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                        <div class="card h-100" onclick="window.location='{{ route('tickets.info', $reserva->id) }}'"
                            style="cursor: pointer;">

                            <img src="{{ asset('storage/imagenes/' . ($reserva->pelicula->imagen ?? 'spain_cinema_logo_circular.jpg')) }}"
                                class="card-img-top" alt="{{ $reserva->pelicula->nombre ?? 'Imagen no disponible' }}">
                            <div class="card-body">

                                <h5 class="card-title">{{ $reserva->pelicula->nombre ?? 'N/A' }}</h5>
                                <p class="card-text"><strong>Asiento:</strong> {{ $reserva->asiento }}</p>
                                <p class="card-text"><strong>Precio:</strong> €{{ number_format($reserva->precio, 2) }}</p>
                                <p class="card-text"><strong>Fecha y Hora:</strong>
                                    {{ \Carbon\Carbon::parse($reserva->fecha_hora)->format('d/m/Y H:i') }}</p>


                                <div class="d-flex flex-column gap-2">
                                    <form action="{{ route('tickets.delete', $reserva->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100 mt-2"
                                            onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                                            Cancelar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination mt-4">
                {{ $reservas->onEachSide(1)->links('pagination::simple-bootstrap-4') }}
            </div>
        @endif
    </section>
@endsection