@extends('layouts.master')

@section('title', 'Restablecer contraseña')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endsection

@section('content')
<div class="login-perfil">
    <h2 style="text-align: center;">Restablecer contraseña</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="form-login-perfil">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group-login">
            <label for="email">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required class="input-login">
        </div>

        <div class="form-group-login">
            <label for="password">Nueva contraseña</label>
            <input id="password" type="password" name="password" required class="input-login">
        </div>

        <div class="form-group-login">
            <label for="password-confirm">Confirmar contraseña</label>
            <input id="password-confirm" type="password" name="password_confirmation" required class="input-login">
        </div>

        <div style="text-align: center; margin-top: 1rem;">
            <button type="submit" class="btn-guardar-cambios">Restablecer contraseña</button>
        </div>
    </form>
</div>
@endsection
