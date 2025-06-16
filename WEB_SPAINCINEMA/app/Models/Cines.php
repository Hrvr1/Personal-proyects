<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Peliculas;
use App\Models\Salas;

class Cines extends Model
{
    use HasFactory;

    protected $table = 'cines';

    protected $fillable = [
      'nombre',
      'localidad',
      'direccion',
      'cantidad_salas',
    ];
    
    /**
     * Método para mostrar la cartelera del cine.
     */
    public function mostrar_cartelera()
    {
      return $this->hasMany(Peliculas::class);
    }

    /**
     * Relación con las salas del cine.
     */
    public function salas()
    {
      return $this->hasMany(Salas::class, 'cine_id');
    }

    public function peliculas()
    {
        return $this->belongsToMany(Peliculas::class, 'cine_pelicula', 'cine_id', 'pelicula_id');
    }

    public function asientos()
    {
        return $this->hasManyThrough(Asientos::class, Salas::class, 'cine_id', 'sala_id');
    }
}
