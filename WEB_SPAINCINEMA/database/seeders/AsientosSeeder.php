<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaPelicula;
use App\Models\Asientos;

class AsientosSeeder extends Seeder
{
    public function run()
    {
        // Obtener todas las sesiones (sala_pelicula)
        $sesiones = SalaPelicula::all();

        foreach ($sesiones as $sesion) {
            $numerosGenerados = []; // Para evitar duplicados

            for ($i = 1; $i <= 4; $i++) {
                do {
                    $numeroAleatorio = rand(1, 100); // Generar un número aleatorio entre 1 y 100
                } while (in_array($numeroAleatorio, $numerosGenerados)); // Evitar duplicados

                $numerosGenerados[] = $numeroAleatorio;

                Asientos::create([
                    'sala_pelicula_id' => $sesion->id,
                    'numero' => $numeroAleatorio, // Número del asiento aleatorio
                ]);
            }
        }
    }
}