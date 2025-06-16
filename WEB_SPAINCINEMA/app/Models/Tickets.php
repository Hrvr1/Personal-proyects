<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peliculas;

class Tickets extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    const ESTADO_COMPRADO = 'comprado';
    const ESTADO_RESERVADO = 'reservado';

    protected $fillable = [
        'asiento',
        'user_id',
        'pelicula_id',
        'sala_id',
        'fecha_hora',
        'precio',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asiento()
    {
        return $this->hasOne(Asientos::class, 'numero', 'asiento')
                    ->where('sala_pelicula_id', $this->sala_id);
    }

    public function pelicula()
    {
        return $this->belongsTo(Peliculas::class, 'pelicula_id');
    }

    public function sala()
    {
        return $this->belongsTo(Salas::class, 'sala_id');
    }

    public function scopeReservados($query)
    {
        return $query->where('estado', self::ESTADO_RESERVADO)
                    ->where('fecha_reserva_expiracion', '>', now());
    }

    public function estaReservado()
    {
        return $this->estado === self::ESTADO_RESERVADO;
    }
}