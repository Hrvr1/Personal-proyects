<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Peliculas;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $peliculas = Peliculas::all();
        foreach (range(1, 20) as $i) {
            $puntuacion = rand(1, 5);
        
            $user = $users->random();
            $pelicula = $peliculas->random();
        
            if ($puntuacion <= 2) {
                $comentarioExtra = 'no me gustó mucho.';
            } elseif ($puntuacion == 3) {
                $comentarioExtra = 'estuvo bien, pero podría mejorar.';
            } else {
                $comentarioExtra = 'me encantó!';
            }
        
            $comentario = "Soy {$user->nombre} y la película {$pelicula->nombre} {$comentarioExtra}";
        
            Review::create([
                'pelicula_id' => $pelicula->id,
                'user_id' => $user->id,
                'puntuacion' => $puntuacion,
                'comentario' => $comentario,
            ]);
        }
    }
}