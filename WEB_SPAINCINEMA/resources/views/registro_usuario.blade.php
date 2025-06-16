@extends('layouts.master')

@section('title', 'Registro de Usuario')

@section('content')
<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <div class="registro-perfil">
        <h2>Registro</h2>
        <form action="{{ isset($isAdmin) && $isAdmin ? route('admin.registrarAdmin') : route('register') }}" method="POST"
            class="form-registro-perfil">
            @csrf
            <input type="hidden" name="isAdmin" value="{{ isset($isAdmin) && $isAdmin ? '1' : '0' }}">

            <div class="form-group-registro">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="nombre" placeholder="Ingresa tu nombre" required>
            </div>
            <div class="form-group-registro">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" placeholder="Ingresa tus apellidos" required>
            </div>
            <div class="form-group-registro">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required>
            </div>
            <div class="form-group-registro">
                <div class="form-group-registro">
                    <label for="password">Contraseña</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                        <button type="button" class="toggle-password">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group-registro">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <div class="password-container">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirma tu contraseña" required>
                        <button type="button" class="toggle-password">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                </div>
                <button type="submit" class="btn-guardar-cambios">Registrarse</button>
        </form>

        @if (!isset($isAdmin) || !$isAdmin)
            <a href="{{ route('login') }}" class="register-link">¿Ya tienes cuenta? Inicia sesión aquí</a>
        @endif
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
@endsection