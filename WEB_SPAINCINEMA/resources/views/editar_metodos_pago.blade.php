@extends('layouts.master')

@section('title', 'Añadir/Editar Tarjeta')

@section('content')
<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">

    <section class="editar-perfil">
        <h1>Añadir/Editar Tarjeta</h1>
        <form action="{{ route('pago.editar') }}" method="POST" class="form-editar-perfil">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="password-container">
                    <input type="password" id="password" name="password">
                    <button type="button" id="togglePassword" class="toggle-password">
                        <i id="eyeIconPassword" class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="form-group">
                <label for="numero">Número de Tarjeta</label>
                <div class="tarjeta-container">
                    <input type="text" id="numero" name="numero"
                        value="**** **** **** {{ substr(Auth::user()->tarjeta, -4) }}" maxlength="19" disabled>
                    <br>
                    <button type="button" id="mostrar-tarjeta" class="btn-mostrar-tarjeta">
                        <i class="fas fa-eye"></i> Mostrar
                    </button>
                </div>
            </div>
            <h2>Datos de Facturación</h2>
            <div class="facturacion-container">
                <div class="facturacion-column">
                    <div class="form-group">
                        <label for="nombre_completo">Nombre Completo</label>
                        <input type="text" id="nombre_completo" name="nombre_completo"
                            value="{{ old('nombre_completo', $facturacion['nombre_completo'] ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="direccion1">Dirección 1</label>
                        <input type="text" id="direccion1" name="direccion1"
                            value="{{ old('direccion1', $facturacion['direccion1'] ?? '') }}" >
                    </div>
                    <div class="form-group">
                        <label for="direccion2">Dirección 2 (Opcional)</label>
                        <input type="text" id="direccion2" name="direccion2"
                            value="{{ old('direccion2', $facturacion['direccion2'] ?? '') }}">
                    </div>
                </div>
                <div class="facturacion-column">
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input type="text" id="ciudad" name="ciudad"
                            value="{{ old('ciudad', $facturacion['ciudad'] ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="provincia">Provincia</label>
                        <input type="text" id="provincia" name="provincia"
                            value="{{ old('provincia', $facturacion['provincia'] ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="codigo_postal">Código Postal</label>
                        <input type="text" id="codigo_postal" name="codigo_postal"
                            value="{{ old('codigo_postal', $facturacion['codigo_postal'] ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" id="telefono" name="telefono"
                            value="{{ old('telefono', $facturacion['telefono'] ?? '') }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-guardar-cambios">Guardar Cambios</button>
        </form>
        <a href="{{ route('perfil') }}" class="btn-volver">Volver</a>
    </section>

    <script>
        
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = document.getElementById('eyeIconPassword');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('mostrar-tarjeta').addEventListener('click', function () {
            const password = document.getElementById('password').value;
            if (!password) {
                alert('Por favor, ingresa tu contraseña.');
                return;
            }

            fetch('{{ route('validar.contraseña') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ password })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const numeroInput = document.getElementById('numero');
                        numeroInput.value = data.numeroTarjeta;
                        numeroInput.disabled = false;
                    } else {
                        alert('Contraseña incorrecta.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al validar la contraseña.');
                });
        });

        document.getElementById('numero').addEventListener('focus', function () {
            if (this.disabled) {
                alert('Debes mostrar la tarjeta antes de editarla.');
                this.blur();
            }
        });
    </script>
@endsection