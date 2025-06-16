@extends('layouts.master')

@section('title', 'Recuperar contraseña')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endsection

@section('content')
<div class="login-perfil">
    <h2>¿Olvidaste tu contraseña?</h2>
    <form method="POST" action="{{ route('password.email') }}" class="form-login-perfil">
        @csrf
        <div class="form-group-login">
            <label for="email">Correo electrónico:</label>
            <input id="email" type="email" name="email" required class="input-login" placeholder="Ingresa tu correo">
        </div>

        <button type="submit" class="btn-guardar-cambios">
            Enviar enlace de recuperación
        </button>
    </form>

    <div style="text-align: center; margin-top: 1rem;">
        <a href="{{ route('index') }}" class="register-link">Volver al inicio</a>
    </div>
</div>
@endsection
