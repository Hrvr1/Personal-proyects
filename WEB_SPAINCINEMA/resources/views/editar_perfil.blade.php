@extends('layouts.master')

@section('title', 'Editar Perfil')

@section('content')
<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <section class="editar-perfil">
        <h1>Editar Perfil</h1>
        <form 
            action="{{ auth()->user()->isAdmin() && isset($usuario) ? route('usuarios.edit', $usuario->id) : route('perfil.editar') }}" 
            method="POST" 
            class="form-editar-perfil">
            @csrf
            @if(auth()->user()->isAdmin() && isset($usuario))
                @method('PUT') 
            @else
                @method('PUT') 
            @endif
            <input type="hidden" name="id" value="{{ $usuario->id ?? $user->id }}">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ $usuario->nombre ?? $user->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" value="{{ $usuario->apellidos ?? $user->apellidos }}" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="{{ $usuario->email ?? $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña (opcional)</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn-guardar-cambios">Guardar Cambios</button>
        </form>
        <a href="{{ auth()->user()->isAdmin() && isset($usuario) ? route('usuarios.index') : route('perfil') }}" class="btn-volver">Volver</a>
    </section>
@endsection