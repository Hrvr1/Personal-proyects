@extends('layouts.master')

@section('title', 'Detalles de la Notificación')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/notificaciones.css') }}">
    <section class="notificacion-detalle-container container mt-4">
        <div class="notificacion-detalle row">
            @if (in_array($notificacion->tipo, ['General', 'Soporte']))
                <div class="col-12">
                    <h1 class="text-center">Detalles de contacto</h1>
                    <p><strong>Tipo:</strong> {{ $notificacion->tipo }}</p>
                    <p><strong>Cine:</strong> {{ $notificacion->cine->localidad }}</p>
                    <p><strong>Consulta:</strong> {{ $notificacion->tipo }}</p>
                    <p><strong>Nombre:</strong> {{ $notificacion->nombre }}</p>
                    <p><strong>Email:</strong> {{ $notificacion->correo }}</p>
                    <p><strong>Mensaje:</strong> {{ $notificacion->mensaje }}</p>
                    <p><strong>Respondida:</strong> {{ $notificacion->respondida ? 'Sí' : 'No' }}</p>
                    @if ($notificacion->respondida)
                        <p><strong>Respuesta:</strong> {{ $notificacion->respuesta }}</p>
                    @endif
                </div>
            @else
                @if ($notificacion->ticket)
                    <div class="container">
                        @if ($notificacion->tipo == 'Recordatorio')
                            <div class="col-12 text-center">
                                <h2>🎬 ¡No olvides tu cita con el cine! 🍿</h2>
                                <p>Hola <strong>{{ $notificacion->nombre }}</strong>,</p>
                                <p>Estamos emocionados de recordarte que tienes una entrada para ver:</p>
                                <p><strong>"{{ $notificacion->ticket->pelicula->nombre }}"</strong></p>
                                <p>📍 En nuestro cine de <strong>{{ $notificacion->ticket->sala->cine->localidad }}</strong></p>
                                <p>🕒 Sala: <strong>{{ $notificacion->ticket->sala->numero }}</strong>, el día
                                    <strong>{{ \Carbon\Carbon::parse($notificacion->ticket->fecha_hora)->format('d/m/Y') }}</strong> a
                                    las
                                    <strong>{{ \Carbon\Carbon::parse($notificacion->ticket->fecha_hora)->format('H:i') }}</strong>.
                                </p>
                                <p>¡Te esperamos para disfrutar de una experiencia inolvidable!</p>
                            </div>
                        @elseif ($notificacion->tipo == 'Reserva')
                            <div class="col-12 text-center">
                                <h2>🎬 ¡Tu reserva está lista! 🍿</h2>
                                <p>Hola <strong>{{ $notificacion->nombre }}</strong>,</p>
                                <p>Has reservado tu entrada para ver:</p>
                                <p><strong>"{{ $notificacion->ticket->pelicula->nombre }}"</strong></p>
                                <p>📍 En nuestro cine de <strong>{{ $notificacion->ticket->sala->cine->localidad }}</strong></p>
                                <p>🕒 Sala: <strong>{{ $notificacion->ticket->sala->numero }}</strong>, el día
                                    <strong>{{ \Carbon\Carbon::parse($notificacion->ticket->fecha_hora)->format('d/m/Y') }}</strong> a
                                    las
                                    <strong>{{ \Carbon\Carbon::parse($notificacion->ticket->fecha_hora)->format('H:i') }}</strong>.
                                </p>
                                <p>Apúntate la fecha y hora en tu agenda y no olvides llegar a tiempo!</p>
                            </div>
                        @elseif($notificacion->tipo == 'Compra')
                            <div class="col-12 text-center">
                                <h2>🎬 ¡Tu compra está lista! 🍿</h2>
                                <p>Hola <strong>{{ $notificacion->nombre }}</strong>,</p>
                                <p>Gracias por tu compra! Aquí tienes los detalles de tu entrada:</p>
                                <p><strong>"{{ $notificacion->ticket->pelicula->nombre }}"</strong></p>
                                <p>📍 En nuestro cine de <strong>{{ $notificacion->ticket->sala->cine->localidad }}</strong></p>
                                <p>🕒 Sala: <strong>{{ $notificacion->ticket->sala->numero }}</strong>, el día
                                    <strong>{{ \Carbon\Carbon::parse($notificacion->ticket->fecha_hora)->format('d/m/Y') }}</strong> a
                                    las
                                    <strong>{{ \Carbon\Carbon::parse($notificacion->ticket->fecha_hora)->format('H:i') }}</strong>.
                                </p>
                                <p>¡Te esperamos para disfrutar de una experiencia inolvidable!</p>
                            </div>
                        @endif
                        <div class="ticket-preview col-12 text-center">
                            <img src="{{ asset('storage/imagenes/' . ($notificacion->ticket->pelicula->imagen ?? 'spain_cinema_logo_circular.jpg')) }}"
                                alt="{{ $notificacion->ticket->pelicula->nombre ?? 'Imagen no disponible' }}"
                                class="ticket-image img-fluid">
                            <p><strong>Película:</strong> {{ $notificacion->ticket->pelicula->nombre ?? 'N/A' }}</p>
                            <a href="{{ route('tickets.info', $notificacion->ticket->id) }}"
                                class="notificaciones-btn notificaciones-btn-success btn btn-primary">
                                Ver detalles del ticket
                            </a>
                        </div>
                    </div>
                @else
                    <div class="container text-center">
                        <h2>Error</h2>
                        <p>Lo sentimos, parece que ha ocurrido un problema cargando esta notificación.</p>
                    </div>
                @endif
            @endif
        </div>

        @if (in_array($notificacion->tipo, ['General', 'Soporte']) && auth()->user()->isAdmin())
            <div id="botones-container" class="d-flex justify-content-center gap-3">
                <button id="toggle-respuesta" class="admin-btn btn btn-secondary mt-4">Responder</button>
                <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="admin-btn-danger btn btn-danger mt-4"
                        onclick="return confirm('¿Estás seguro de que deseas borrar esta notificación?')">
                        Borrar
                    </button>
                </form>
            </div>
            <form id="respuesta-form" action="{{ route('notificaciones.responder', $notificacion->id) }}" method="POST"
                style="display: none;" class="mt-3">
                @csrf
                <div class="d-flex justify-content-center">
                    <textarea name="respuesta" rows="4" class="form-control w-75"
                        placeholder="Escribe tu respuesta aquí..."></textarea>
                </div>
                <button type="submit" class="admin-btn btn btn-primary mt-2">Enviar Respuesta</button>
            </form>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('notificaciones.index', ['tab' => in_array($notificacion->tipo, ['General', 'Soporte']) ? 'contacto' : 'notificaciones']) }}"
                class="btn btn-secondary">Volver a la lista</a>
        </div>
    </section>

    @if (in_array($notificacion->tipo, ['General', 'Soporte']))
        <script>
            document.getElementById('toggle-respuesta').addEventListener('click', function () {
                const botonesContainer = document.getElementById('botones-container');
                const respuestaForm = document.getElementById('respuesta-form');
                botonesContainer.style.display = 'none';
                respuestaForm.style.display = 'block';
            });
        </script>
    @endif
@endsection