@extends('layouts.master')

@section('title', 'Gestión de Notificaciones')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/notificaciones.css') }}">
    <section class="notificaciones-container container">
        <h1 class="text-center">Notificaciones</h1>

        @if ($notificaciones->isEmpty())
            <div class="alert alert-danger text-center">
                No hay notificaciones disponibles.
            </div>
        @else
            <div class="tabs-header row">
            <div class="col-6">
                    <button class="tab-button active btn btn-primary w-100" data-tab="notificaciones">General</button>
                </div>
                <div class="col-6">
                    <button class="tab-button btn btn-primary w-100" data-tab="contacto">Contacto</button>
                </div>
            </div>
            <div class="tabs-content">
                <div class="tab-content" id="contacto">
                    @if ($notificaciones->where('tipo', 'General')->merge($notificaciones->where('tipo', 'Soporte'))->isEmpty())
                        <div class="alert alert-danger text-center">
                            No hay notificaciones disponibles.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="notificaciones-table table table-striped table-bordered centered-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Respondida</th>
                                        <th>Respuesta</th>
                                        @if (auth()->user()->isAdmin())
                                            <th>Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notificaciones->where('tipo', 'General')->merge($notificaciones->where('tipo', 'Soporte'))->sortByDesc('created_at') as $notificacion)
                                        <tr class="clickable-row" data-href="{{ route('notificaciones.show', $notificacion->id) }}">
                                            <td>{{ $notificacion->tipo }}</td>
                                            <td>{{ $notificacion->nombre }}</td>
                                            <td>{{ $notificacion->correo }}</td>
                                            <td>{{ $notificacion->respuesta ? 'Sí' : 'No' }}</td>
                                            @if ($notificacion->respuesta)
                                                <td>{{ Str::limit($notificacion->respuesta, 50) }}</td>
                                            @else
                                                <td>
                                                    @if (auth()->user()->isAdmin())
                                                        <div id="botones-container-{{ $notificacion->id }}">
                                                            <button id="toggle-respuesta-{{ $notificacion->id }}"
                                                                class="admin-btn btn btn-primary">Responder</button>
                                                        </div>
                                                        <form id="respuesta-form-{{ $notificacion->id }}"
                                                            action="{{ route('notificaciones.responder', $notificacion->id) }}" method="POST"
                                                            style="display: none; margin-top: 10px;">
                                                            @csrf
                                                            <div class="respuesta-form-container">
                                                                <textarea name="respuesta" rows="4" placeholder="Escribe tu respuesta aquí..."
                                                                    class="form-control"></textarea>
                                                                <button type="submit" class="admin-btn btn btn-success mt-2">Enviar Respuesta</button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        Sin responder
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                @if (auth()->user()->isAdmin())
                                                    <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="admin-btn-danger btn btn-danger"
                                                            onclick="return confirm('¿Estás seguro de que deseas borrar esta notificación?')">
                                                            Borrar
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="tab-content active" id="notificaciones">
                    @if ($notificaciones->whereNotIn('tipo', ['General', 'Soporte'])->isEmpty())
                        <div class="alert alert-danger text-center">
                            No hay notificaciones disponibles.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="notificaciones-table table table-striped table-bordered centered-table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Categoría</th>
                                        <th>Detalles</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notificaciones->whereNotIn('tipo', ['General', 'Soporte'])->sortByDesc('created_at') as $notificacion)
                                        <tr class="clickable-row" data-href="{{ route('notificaciones.show', $notificacion->id) }}">
                                            <td>{{ $notificacion->tipo }}</td>
                                            <td>{{ $notificacion->mensaje }}</td>
                                            <td>{{ $notificacion->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <form action="{{ route('notificaciones.destroy', $notificacion->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-btn-danger btn btn-danger"
                                                        onclick="return confirm('¿Estás seguro de que deseas borrar esta notificación?')">
                                                        Borrar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
        @endif
    </section>

    <script>
        const rows = document.querySelectorAll('.clickable-row');
        rows.forEach(row => {
            row.addEventListener('click', function (event) {
                const href = this.dataset.href;
                if (href) {
                    window.location.href = href;
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        // Restaurar la última pestaña activa desde localStorage
        const lastActiveTab = localStorage.getItem('activeTab');
        if (lastActiveTab) {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            const activeButton = document.querySelector(`.tab-button[data-tab="${lastActiveTab}"]`);
            const activeContent = document.getElementById(lastActiveTab);

            if (activeButton && activeContent) {
                activeButton.classList.add('active');
                activeContent.classList.add('active');
            }
        }

        // Manejar clics en las pestañas
        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetTab = this.getAttribute('data-tab');

                // Guardar la pestaña activa en localStorage
                localStorage.setItem('activeTab', targetTab);

                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                tabContents.forEach(content => {
                    if (content.id === targetTab) {
                        content.classList.add('active');
                    } else {
                        content.classList.remove('active');
                    }
                });
            });
        });

        const interactiveElements = document.querySelectorAll('textarea, button, form');
        interactiveElements.forEach(element => {
            element.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        });
    });


        @foreach ($notificaciones as $notificacion)
            const toggleButton{{ $notificacion->id }} = document.getElementById('toggle-respuesta-{{ $notificacion->id }}');
            if (toggleButton{{ $notificacion->id }}) {
                toggleButton{{ $notificacion->id }}.addEventListener('click', function (event) {
                    event.stopPropagation();
                    const botonesContainer = document.getElementById('botones-container-{{ $notificacion->id }}');
                    const respuestaForm = document.getElementById('respuesta-form-{{ $notificacion->id }}');
                    botonesContainer.style.display = 'none';
                    respuestaForm.style.display = 'block';
                });
            }
        @endforeach
    </script>

@endsection