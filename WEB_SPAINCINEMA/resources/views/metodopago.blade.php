@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/metodopago.css') }}">
@endsection

@section('title', 'Método de Pago')

@section('content')
<div class="metodo-pago-container">
    <div class="resumen-compra">
        <h1>Resumen de tu Compra</h1>
        <div class="resumen-detalles">
            <p><strong>Sala:</strong> {{ $sala->numero }}</p>
            <p><strong>Película:</strong> {{ $pelicula->nombre }}</p>
            <p><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($fechaHora)->format('d/m/Y H:i') }}</p>
            <p><strong>Asientos seleccionados:</strong> {{ implode(', ', $asientosSeleccionados) }}</p>
            <p><strong>Precio por asiento:</strong> €{{ number_format($precioPorAsiento, 2) }}</p>
            <p><strong>Total:</strong> €{{ number_format($total, 2) }}</p>
        </div>
    </div>

    <div class="informacion-pago">
        <h2>Información de Pago</h2>
        <form action="{{ route('pago.procesar') }}" method="POST">
            @csrf
            <input type="hidden" name="sala_id" value="{{ $sala->id }}">
            <input type="hidden" name="pelicula_id" value="{{ $pelicula->id }}">
            <input type="hidden" name="fecha_hora" value="{{ $salaPelicula->id }}|{{ $fechaHora }}">
            <input type="hidden" name="asientos" value="{{ implode(',', $asientosSeleccionados) }}">
            <input type="hidden" name="total" value="{{ $total }}">

            @if ($tarjetaGuardada)
                <p><strong>Tarjeta Guardada:</strong> **** **** **** {{ substr($tarjetaGuardada, -4) }}</p>
            @else
                <div class="form-group">
                    <label for="tarjeta">Número de Tarjeta:</label>
                    <input type="text" name="tarjeta" id="tarjeta" placeholder="Introduce tu tarjeta" required>
                </div>
            @endif

            <button type="submit" class="btn-pagar">Pagar</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cantidadInput = document.getElementById('cantidad');
        const precioUnitario = parseFloat(document.getElementById('precio-unitario').textContent);
        const precioTotalElement = document.getElementById('precio-total');
        const precioHiddenInput = document.getElementById('precio-hidden');
        const cantidadHiddenInput = document.getElementById('cantidad-hidden');

        // Actualizar el precio total dinámicamente
        cantidadInput.addEventListener('input', function () {
            const cantidad = parseInt(cantidadInput.value) || 1; // Asegurarse de que sea un número válido
            const precioTotal = (cantidad * precioUnitario).toFixed(2);
            precioTotalElement.textContent = precioTotal;

            // Actualizar los valores ocultos para el formulario
            precioHiddenInput.value = precioUnitario;
            cantidadHiddenInput.value = cantidad;
        });
    });
</script>

@endsection