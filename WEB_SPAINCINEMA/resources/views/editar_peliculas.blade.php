@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/peliculas.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@endsection

@section('title', 'Editar Película')

@section('content')
<div class="container editar-pelicula-container">
    <h1 class="text-center my-4">Editar Película</h1>
    <div class="text-center mb-4">
        <a href="{{ route('peliculas.show.admin', ['id' => $pelicula->id] ) }}">
            <img src="{{ asset('storage/imagenes/' . $pelicula->imagen) }}" alt="{{ $pelicula->nombre }}" class="editar-pelicula-imagen">
        </a>
    </div>
    
    <form action="{{ route('peliculas.update', $pelicula->id) }}" method="POST" class="editar-pelicula-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $pelicula->nombre) }}" required>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="fecha_estreno" class="form-label">Fecha de Estreno</label>
                <input type="date" id="fecha_estreno" name="fecha_estreno" class="form-control" value="{{ old('fecha_estreno', $pelicula->fecha_estreno) }}" required>
            </div>
            
            <div class="col-md-6">
                <label for="precio" class="form-label">Precio (€)</label>
                <input type="number" id="precio" name="precio" class="form-control" step="0.01" min="0" value="{{ old('precio', $pelicula->precio) }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="genero" class="form-label">Género</label>
                <input type="text" id="genero" name="genero" class="form-control" value="{{ old('genero', $pelicula->genero) }}" required>
            </div>
            
            <div class="col-md-6">
                <label for="duracion" class="form-label">Duración (minutos)</label>
                <input type="number" id="duracion" name="duracion" class="form-control" min="1" value="{{ old('duracion', $pelicula->duracion) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $pelicula->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="trailer" class="form-label">URL del Tráiler</label>
            <input type="url" id="trailer" name="trailer" class="form-control" value="{{ old('trailer', $pelicula->trailer) }}" placeholder="https://www.youtube.com/watch?v=..." required>
            @error('trailer')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Nueva Imagen (Opcional)</label>
            <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*" onchange="previewImage(event)">
            <div id="preview-container" class="mt-3">
                <img id="preview-image" class="editar-pelicula-imagen img-fluid" alt="Previsualización de la imagen">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('peliculas.gestionar') }}" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const previewImage = document.getElementById('preview-image');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block'; // Mostrar la imagen
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            previewImage.style.display = 'none'; // Ocultar si no hay archivo
        }
    }
</script>
@endsection