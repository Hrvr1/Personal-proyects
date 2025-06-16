@extends('layouts.master')

@section('title', 'Detalle del Ticket')

@section('content')
<link rel="stylesheet" href="{{ asset('css/tickets.css') }}">
    <div class="ticket-wrapper">
        <div class="ticket-container">
            <h1 class="ticket-title">
                🎟️ Detalles de la entrada
            </h1>


            <img src="{{ asset('storage/imagenes/' . ($ticket->pelicula->imagen ?? 'spain_cinema_logo_circular.jpg')) }}"
                alt="{{ $ticket->pelicula->nombre ?? 'Imagen no disponible' }}" class="ticket-image">

            <table class="ticket-table">
                <tr>
                    <th>Cine</th>
                    <td>{{ $ticket->sala->cine->nombre }} - {{ $ticket->sala->cine->localidad }}</td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <td>{{ $ticket->usuario->nombre }} {{ $ticket->usuario->apellidos }}</td>
                </tr>
                <tr>
                    <th>Asiento</th>
                    <td>{{ $ticket->asiento }}</td>
                </tr>
                <tr>
                    <th>Precio</th>
                    <td>€{{ number_format($ticket->precio, 2) }}</td>
                </tr>
                <tr>
                    <th>Película</th>
                    <td>{{ $ticket->pelicula->nombre ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Sala</th>
                    <td>{{ $ticket->sala_id }}</td>
                </tr>
                <tr>
                    <th>Fecha y Hora</th>
                    <td>{{ \Carbon\Carbon::parse($ticket->fecha_hora)->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Fecha de Compra</th>
                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>

            <a href="{{ route('tickets.index') }}" class="btn-volver">
                Mis tickets
            </a>
            <button onclick="printTicket()" class="btn-imprimir">
                Imprimir
            </button>
        </div>
    </div>
@endsection

<script>
    function printTicket() {
        const ticketContent = document.querySelector('.ticket-container').innerHTML;
        const originalContent = document.body.innerHTML;
        document.body.innerHTML = ticketContent;
        window.print();
        document.body.innerHTML = originalContent;
    }

</script>