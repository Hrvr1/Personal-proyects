@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/peliculas.css') }}">
@endsection

@section('title', 'Añadir Nueva Película')

@section('content')
<div class="create-pelicula-container">
    <h1>Añadir Nueva Película</h1>
    <form action="{{ route('peliculas.store.public') }}" method="POST" class="create-pelicula-form" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="nombre">Nombre de la Película</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <span class="create-error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="fecha_estreno">Fecha de Estreno</label>
            <input type="date" id="fecha_estreno" name="fecha_estreno" value="{{ old('fecha_estreno') }}" required>
            @error('fecha_estreno')
                <span class="create-error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="precio">Precio (€)</label>
            <input type="number" id="precio" name="precio" step="0.01" min="0" value="{{ old('precio') }}" required>
            @error('precio')
                <span class="create-error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="genero">Género</label>
            <input type="text" id="genero" name="genero" value="{{ old('genero') }}" required>
            @error('genero')
                <span class="create-error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="duracion">Duración (minutos)</label>
            <input type="number" id="duracion" name="duracion" min="1" value="{{ old('duracion') }}" required>
            @error('duracion')
                <span class="create-error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required>{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <span class="create-error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="trailer">URL del Tráiler</label>
            <input type="url" id="trailer" name="trailer" value="{{ old('trailer') }}" placeholder="https://www.youtube.com/watch?v=..." required>
            @error('trailer')
                <span class="create-error-message">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="imagen">Imagen de la Película</label>
            <input type="file" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)" required>
            <div id="preview-container">
                <img id="preview-image" class="editar-pelicula-imagen" alt="Previsualización de la imagen">
            </div>
            @error('imagen')
                <span class="create-error-message">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="create-btn-guardar-cambios">Crear película</button>
    </form>
    <a href="{{ route('peliculas.gestionar') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
<script>
    function previewImage(event) {
        const input = event.target;
        const previewImage = document.getElementById('preview-image');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block'; 
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            previewImage.style.display = 'none'; 
        }
    }
</script>
@endsection
