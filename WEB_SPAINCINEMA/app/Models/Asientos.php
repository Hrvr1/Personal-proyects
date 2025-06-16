<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asientos extends Model
{
    use HasFactory;

    protected $fillable = [
        'sala_pelicula_id',
        'numero',
    ];

    public function salaPelicula()
    {
        return $this->belongsTo(SalaPelicula::class, 'sala_pelicula_id');
    }
}