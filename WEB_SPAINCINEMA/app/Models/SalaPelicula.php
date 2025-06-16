<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaPelicula extends Model
{
    protected $table = 'sala_pelicula';

    protected $fillable = [
        'sala_id',
        'pelicula_id',
        'fecha_hora',
    ];

    public function sala()
    {
        return $this->belongsTo(Salas::class, 'sala_id');
    }

    public function pelicula()
    {
        return $this->belongsTo(Peliculas::class, 'pelicula_id');
    }

    public function asientos()
    {
        return $this->hasMany(Asientos::class, 'funcion_id');
    }
}