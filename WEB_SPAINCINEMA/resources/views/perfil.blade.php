@extends('layouts.master')

@section('title', 'Perfil de Usuario')

@section('content')
<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
<div class="container perfil-container">
    <h1 class="text-center">Perfil</h1>
    <div class="datos-usuario bg-light p-4 rounded shadow-sm">
        <p><strong>Nombre:</strong> {{ $user->nombre }}</p>
        <p><strong>Apellidos:</strong> {{ $user->apellidos }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        @if ($user->tarjeta)
            <p class="tarjeta"><strong>Tarjeta:</strong> <span>**** **** **** {{ substr($user->tarjeta, -4) }}</span></p>
        @else
            <p class="tarjeta-vacia">No hay tarjeta registrada</p>
        @endif
    </div>
    <div class="perfil-botones d-flex flex-wrap justify-content-center gap-3 mt-4">
        @if (auth()->id() === $user->id)
            <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary d-flex align-items-center">
                <i class="fas fa-ticket-alt me-2"></i>
                Mis tickets
            </a>
            <a href="{{ route('perfil.editar') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="fas fa-user-edit me-2"></i>
                Editar perfil
            </a>
            <a href="{{ route('pago.editar.view') }}" class="btn btn-outline-success d-flex align-items-center">
                <i class="fas fa-credit-card me-2"></i>
                Añadir/Editar métodos de pago
            </a>
            <form action="{{ route('perfil.borrar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas borrar tu perfil?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger d-flex align-items-center">
                    <i class="fas fa-trash-alt me-2"></i>
                    Borrar cuenta
                </button>
            </form>
        @else
            @if (auth()->user()->isAdmin())
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-dark d-flex align-items-center">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver a la lista de usuarios
                </a>
            @endif
        @endif
    </div>
</div>
@endsection