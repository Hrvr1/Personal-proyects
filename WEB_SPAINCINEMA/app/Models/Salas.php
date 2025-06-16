<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
    use HasFactory;

    protected $table = 'salas';

    protected $fillable = [
        'numero',
        'capacidad',
        'cine_id'
    ];

    /**
     * Relación con la entidad Cine
     */
    public function cine()
    {
        return $this->belongsTo(Cines::class, 'cine_id');
    }

    /**
     * Relación con la entidad Pelicula (una sala puede emitir varias películas en distintos horarios)
     */
    public function peliculas()
    {
        return $this->belongsToMany(Peliculas::class, 'sala_pelicula', 'sala_id', 'pelicula_id')
                    ->withPivot('id' ,'fecha_hora')
                    ->withTimestamps();
    }

    public function pelicula()
    {
        return $this->peliculas()->orderBy('fecha_hora', 'desc')->first();
    }
    
    public function asientos()
    {
        return $this->hasMany(Asientos::class, 'sala_id');
    }

    /**
     * Método para mostrar la capacidad disponible
     */
    public function mostrar_capacidad_disponible()
    {
        return $this->capacidad; // Aquí se podría modificar para restar las reservas en el futuro
    }

    public function funciones()
    {
       return $this->hasMany(SalaPelicula::class, 'sala_id');
    }
    
}
