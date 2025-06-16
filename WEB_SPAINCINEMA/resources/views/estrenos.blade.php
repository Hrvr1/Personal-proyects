@extends('layouts.master')



@section('title', 'Estrenos - ' . $cine->nombre)

@section('content')
    <div class="cine-container">
        <link rel="stylesheet" href="{{ asset('css/peliculas.css') }}">
        <h1 class="titulo">Estrenos de {{ $cine->nombre }} - {{ $cine->localidad }}</h1>
        {{-- Barra de búsqueda y filtros --}}
        <form method="GET" action="{{ route('estrenos', $cine->id) }}" class="search-form container">
            <div class="row g-3">
                {{-- Buscador por nombre --}}
                <div class="col-12 col-md-6">
                    <input type="text" id="nombre" name="nombre" placeholder="Buscar por película..."
                        value="{{ request('nombre') }}" class="form-control" />
                </div>
                {{-- Filtro por fecha y hora --}}
                <div class="col-12 col-md-6">
                    <input type="date" id="dia_sesion" name="dia_sesion" value="{{ request('dia_sesion') }}"
                        class="form-control" />
                </div>
                <div class="col-12 col-md-6">
                    <input type="time" id="hora_sesion" name="hora_sesion" value="{{ request('hora_sesion') }}"
                        class="form-control" />
                </div>

                {{-- Ordenar por fecha de estreno --}}
                <div class="col-12 col-md-6">
                    <select name="ordenar" class="form-select">
                        <option value="">Ordenar</option>
                        <option value="asc" {{ request('ordenar') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ request('ordenar') == 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>
                </div>
                {{-- Filtro por género --}}
                <div class="col-12 col-md-6">
                    <button type="button" id="toggle-genero-btn" class="btn btn-primary w-100">Mostrar géneros</button>
                    <div class="genero-checklist mt-2" id="genero-checklist" style="display: none;">
                        @foreach($generos as $genero)
                            <div class="form-check">
                                <label for="genero_{{ $loop->index }}" class="form-check-label">{{ $genero }}</label>
                                <input type="checkbox" id="genero_{{ $loop->index }}" name="generos[]" value="{{ $genero }}"
                                    class="form-check-input" {{ in_array($genero, request('generos', [])) ? 'checked' : '' }}>
                            </div>
                        @endforeach
                    </div>
                </div>
                {{-- Botones de aplicar y quitar filtros --}}
                <div class="col-12 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100">Aplicar Filtros</button>
                    <a href="{{ route('estrenos', $cine->id) }}" class="btn btn-danger w-100">Quitar Filtros</a>
                </div>
            </div>
        </form>
        @if ($peliculas->isEmpty())
            <p>No hay películas disponibles en este cine.</p>
        @else
            <div class="cartelera-grid">
                @foreach ($peliculas as $pelicula)
                    <div class="pelicula-card">
                        <a href="{{ route('peliculas.show.public', ['id' => $pelicula->id, 'cine_id' => $cine->id]) }}">
                            <img src="{{ asset('storage/imagenes/' . $pelicula->imagen) }}" alt="{{ $pelicula->nombre }}"
                                class="pelicula-imagen">
                        </a>

                        <div class="pelicula-info">
                            <h2>{{ $pelicula->nombre }}</h2>
                            <p><strong>Género:</strong> {{ $pelicula->genero }}</p>
                            <p><strong>Duración:</strong> {{ $pelicula->duracion }} minutos</p>
                            <p class="descripcion-corta"><strong>Descripción:</strong> {{ Str::limit($pelicula->descripcion, 200) }}
                            </p>
                            <p><strong>Sesiones disponibles:</strong></p>
                            @php
                                // Obtener todas las funciones de la película en este cine y ordenarlas por fecha y hora
                                $funciones = $pelicula->salas->filter(function ($sala) use ($cine) {
                                    return $sala->cine_id === $cine->id;
                                })->sortBy(function ($sala) {
                                    return $sala->pivot->fecha_hora ?? null;
                                });
                            @endphp

                            @if ($funciones->isEmpty())
                                <p>No disponible</p>
                            @else
                                <ul class="funciones-lista">
                                    @foreach ($funciones as $sala)
                                        @if($sala->pivot && $sala->pivot->fecha_hora)
                                            <li>{{ \Carbon\Carbon::parse($sala->pivot->fecha_hora)->format('d/m/Y H:i') }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="paginacion">
                {{ $peliculas->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>

    <script>
        document.getElementById('toggle-genero-btn').addEventListener('click', function () {
            const checklist = document.getElementById('genero-checklist');
            const isHidden = checklist.style.display === 'none';
            checklist.style.display = isHidden ? 'block' : 'none';
            this.textContent = isHidden ? 'Ocultar géneros' : 'Mostrar géneros';
        });
    </script>

@endsection