<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Review;

class Peliculas extends Model
{
    use HasFactory;

    protected $table = 'peliculas';

    protected $fillable = [
        'nombre',
        'fecha_estreno',
        'genero',
        'precio',
        'descripcion',
        'duracion',
        'imagen',
        'trailer',
    ];

    /**
     * Relación con la entidad Sala (una película puede emitirse en varias salas)
     */
    public function salas()
    {
        return $this->belongsToMany(Salas::class, 'sala_pelicula', 'pelicula_id', 'sala_id')
                    ->withPivot('id', 'fecha_hora')
                    ->withTimestamps();
    }
    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }
    public function funciones()
    {
        return $this->hasMany(SalaPelicula::class, 'pelicula_id');
    }

    public function cines()
    {
        return $this->belongsToMany(Cines::class, 'cine_pelicula', 'pelicula_id', 'cine_id');
    }

    public static function obtenerFuncionPorId($peliculaId, $funcionData)
    {
        if (!$funcionData || !str_contains($funcionData, '|')) {
            return null;
        }

        [$salaId, $fechaHora] = explode('|', $funcionData);

        $pelicula = self::find($peliculaId);
        return $pelicula ? $pelicula->salas()->where('sala_id', $salaId)->where('fecha_hora', $fechaHora)->first() : null;
    }

    public static function obtenerPrecioPorId($id)
    {
        $pelicula = self::find($id);
        return $pelicula ? $pelicula->precio : null;
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'pelicula_id');
    }

    public function esEstreno(): bool
    {
        return Carbon::parse($this->fecha_estreno)->isFuture();
    }

}