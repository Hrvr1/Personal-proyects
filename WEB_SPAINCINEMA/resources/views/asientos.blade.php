@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/asientos.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('title', 'Selecciona tus Asientos')

@section('content')
<div class="asientos-container">
    <h1>ELIGE TU ASIENTO</h1>
    <div class="leyenda">
        <div class="leyenda-item">
            <span class="disponible"></span> Disponible
        </div>
        <div class="leyenda-item">
            <span class="seleccionado"></span> Seleccionado
        </div>
        <div class="leyenda-item">
            <span class="ocupado"></span> Ocupado
        </div>
    </div>
    <div class="sala">
        <div class="pantalla">PANTALLA</div>
        <form action="{{ route('metodo.pago') }}" method="GET">
            @csrf
            <input type="hidden" name="pelicula_id" value="{{ $pelicula->id }}">
            <input type="hidden" name="sala_pelicula_id" value="{{ $salaPelicula->id }}">
            <input type="hidden" name="cantidad" value="{{ $cantidadTickets }}">
            <input type="hidden" name="fecha_hora" value="{{ $fechaHora }}">

            <div class="container">
                <div class="row justify-content-center">
                    @foreach ($asientos as $fila => $asientosFila)
                        @foreach ($asientosFila as $asiento)
                            <div class="col-1 p-1">
                                <label class="asiento {{ in_array($asiento, $asientosOcupados) ? 'ocupado' : '' }}">
                                    <input type="checkbox" name="asientos[]" value="{{ $asiento }}" 
                                        {{ in_array($asiento, $asientosOcupados) ? 'disabled' : '' }}>
                                    <span>{{ $asiento }}</span>
                                </label>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn-continuar">Continuar</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const maxAsientos = {{ $cantidadTickets }};
        const checkboxes = document.querySelectorAll('input[name="asientos[]"]');
        const errorMessage = document.getElementById('error-message');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const selected = Array.from(checkboxes).filter(cb => cb.checked).length;

                if (selected > maxAsientos) {
                    this.checked = false; // Desmarcar el checkbox si excede el límite
                    errorMessage.style.display = 'block';
                } else {
                    errorMessage.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection