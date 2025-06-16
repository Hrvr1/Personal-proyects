@extends('layouts.master')

@section('title', 'Estrenos - ' . $cine->nombre)

@section('content')
    <div class="cine-container">
        <h1>Estrenos de {{ $cine->nombre }} - {{ $cine->localidad }}</h1>

        {{-- Barra de búsqueda y filtros --}}
        <form method="GET" action="{{ route('reservar-estrenos', $cine->id) }}" class="search-form">
            {{-- Buscador por nombre --}}
            <input type="text" id="nombre" name="nombre" placeholder="Buscar por película..."
                value="{{ request('nombre') }}" class="buscador">

            <div class="genero-filter">
                <button type="button" id="toggle-genero-btn" class="search-btn">Mostrar géneros</button>
                <div class="genero-checklist" id="genero-checklist" style="display: none;">
                    @foreach($generos as $genero)
                        <div>
                            <input type="checkbox" id="genero_{{ $loop->index }}" name="generos[]" value="{{ $genero }}" {{ in_array($genero, request('generos', [])) ? 'checked' : '' }}>
                            <label for="genero_{{ $loop->index }}">{{ $genero }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <input type="date" id="dia_sesion" name="dia_sesion" value="{{ request('dia_sesion') }}" class="buscador">
            <input type="time" id="hora_sesion" name="hora_sesion" value="{{ request('hora_sesion') }}" class="buscador">

            {{-- Ordenar por fecha de estreno --}}
            <select name="ordenar" class="sort-direction">
                <option value="">Ordenar</option>
                <option value="asc" {{ request('ordenar') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                <option value="desc" {{ request('ordenar') == 'desc' ? 'selected' : '' }}>Descendente</option>
            </select>

            {{-- Botones de aplicar y quitar filtros --}}
            <button type="submit" class="search-btn">Aplicar Filtros</button>
            <a href="{{ route('estrenos', $cine->id) }}" class="clear-filters-btn">Quitar Filtros</a>
        </form>
        @if ($peliculas->isEmpty())
            <p>No hay películas disponibles en este cine.</p>
        @else
            <div class="estrenos-grid">
                @foreach ($peliculas as $pelicula)
                    <div class="pelicula-card">
                        <a href="{{ route('peliculas.show', ['id' => $pelicula->id, 'cine_id' => $cine->id]) }}">
                            <img src="{{ asset('storage/imagenes/' . $pelicula->imagen) }}" alt="{{ $pelicula->nombre }}"
                                class="pelicula-imagen">
                        </a>

                        <div class="pelicula-info">
                            <h2>{{ $pelicula->nombre }}</h2>
                            <p><strong>Género:</strong> {{ $pelicula->genero }}</p>
                            <p><strong>Duración:</strong> {{ $pelicula->duracion }} minutos</p>
                            <p><strong>Descripción:</strong> {{ Str::limit($pelicula->descripcion, 100) }}</p>
                            <p><strong>Sesiones disponibles:</strong></p>
                            @php
                                // Obtener todas las funciones de la película en este cine
                                $funciones = $pelicula->salas->filter(function ($sala) use ($cine) {
                                    return $sala->cine_id === $cine->id;
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