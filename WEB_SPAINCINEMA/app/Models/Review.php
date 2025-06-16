<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'pelicula_id', 'puntuacion', 'comentario'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function pelicula() {
        return $this->belongsTo(Peliculas::class);
    }
}
