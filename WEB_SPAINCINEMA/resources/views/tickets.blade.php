@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/reservas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tickets.css') }}">
@endsection

@section('title', 'Mis Tickets')

@section('content')
    <section class="mis-tickets container">
        <h1 class="tickets-title text-center my-4">Mis Tickets</h1>
        <div class="w-100 d-flex justify-content-center mb-3">
            <a href="{{ route('tickets.reservados') }}" class="btn btn-primary">
                <i class="fas fa-ticket-alt"></i> Mis Reservas
            </a>
        </div>
        @if($tickets->isEmpty())
            <p class="text-center">No has hecho ninguna compra.</p>
        @else
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <div class="w-100 d-flex justify-content-center mt-3">
                    <form method="GET" action="{{ route('tickets.index') }}"
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

                        <button type="submit" name="ordenar" value="fecha" class="btn btn-secondary me-2">Ordenar por
                            Fecha</button>
                        {{-- Botón de aplicar filtros --}}
                        <button type="submit" class="btn btn-success">Aplicar Filtros</button>
                    </form>
                </div>
            </div>

            <div class="row g-4">
                @foreach($tickets as $ticket)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100" onclick="window.location='{{ route('tickets.info', $ticket->id) }}'"
                            style="cursor: pointer;">
                            <!-- Mostrar la imagen de la película asociada al ticket -->
                            <img src="{{ asset('storage/imagenes/' . ($ticket->pelicula->imagen ?? 'spain_cinema_logo_circular.jpg')) }}"
                                class="card-img-top" alt="{{ $ticket->pelicula->nombre ?? 'Imagen no disponible' }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $ticket->pelicula->nombre ?? 'N/A' }}</h5>
                                <p class="card-text"><strong>Asiento:</strong> {{ $ticket->asiento }}</p>
                                <p class="card-text"><strong>Precio:</strong> €{{ number_format($ticket->precio, 2) }}</p>
                                <p class="card-text"><strong>Fecha y Hora:</strong>
                                    {{ \Carbon\Carbon::parse($ticket->fecha_hora)->format('d/m/Y H:i') }}</p>
                                <form action="{{ route('tickets.delete', $ticket->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100 mt-2"
                                        onclick="return confirm('¿Estás seguro de que deseas cancelar este ticket?')">
                                        Cancelar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination mt-4">
                {{ $tickets->onEachSide(1)->links('pagination::simple-bootstrap-4') }}
            </div>
        @endif
    </section>
@endsection