@extends('layouts.master')

@section('title', 'Login')

@section('content')
<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <div class="login-perfil">
        <h2>Login</h2>
        <div>
            <form action="{{ route('login.post') }}" method="POST" class="form-login-perfil">
                @csrf
                <div class="form-group-login">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', request()->cookie('email')) }}" required>
                </div>
                <div class="form-group-login">
                    <label for="password">Contraseña</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" value="{{ request()->cookie('password') }}" required>
                        <button type="button" id="togglePassword" class="toggle-password">
                            <i id="eyeIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <label class="form form-recordar" for="remember">Recuérdame
                    <input type="checkbox" id="remember" name="remember" {{ request()->old('remember') || request()->cookie('remember') ? 'checked' : '' }}>
                    <svg viewBox="0 0 64 64" height="2em" width="2em">
                        <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path"></path>
                    </svg>
                </label>
                <button type="submit" class="btn-guardar-cambios">Login</button>
            </form>
            <a href="{{ route('register') }}" class="register-link">¿No tienes cuenta? Regístrate aquí</a>
            <br>
            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

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
    </script>
@endsection