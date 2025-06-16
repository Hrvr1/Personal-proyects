<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salas;
use App\Models\Cines;

class SalasSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los cines
        $cines = Cines::all();

        foreach ($cines as $cine) {
            // Crear tantas salas como indique la cantidad_salas del cine
            for ($i = 1; $i <= $cine->cantidad_salas; $i++) {
                Salas::create([
                    'numero' => $i,
                    'capacidad' => rand(50, 150), // Capacidad aleatoria entre 50 y 150 asientos
                    'cine_id' => $cine->id,
                ]);
            }
        }
    }
}