<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinePeliculaSeeder extends Seeder
{
    public function run(): void
    {
        $asociaciones = [
            ['cine_id' => 1, 'pelicula_id' => 1],
            ['cine_id' => 1, 'pelicula_id' => 2],
            ['cine_id' => 1, 'pelicula_id' => 3],
            ['cine_id' => 1, 'pelicula_id' => 4],
            ['cine_id' => 1, 'pelicula_id' => 5],
            ['cine_id' => 1, 'pelicula_id' => 6],
            ['cine_id' => 1, 'pelicula_id' => 7],
            ['cine_id' => 1, 'pelicula_id' => 8],
            ['cine_id' => 1, 'pelicula_id' => 9],
            ['cine_id' => 1, 'pelicula_id' => 10],
            ['cine_id' => 1, 'pelicula_id' => 11],

            ['cine_id' => 2, 'pelicula_id' => 3],
            ['cine_id' => 2, 'pelicula_id' => 4],
            ['cine_id' => 2, 'pelicula_id' => 5],
            ['cine_id' => 2, 'pelicula_id' => 6],
            ['cine_id' => 2, 'pelicula_id' => 7],
            ['cine_id' => 2, 'pelicula_id' => 8],
            ['cine_id' => 2, 'pelicula_id' => 9],
        ];

        foreach ($asociaciones as $asociacion) {
            DB::table('cine_pelicula')->insert($asociacion);
        }
    }
}