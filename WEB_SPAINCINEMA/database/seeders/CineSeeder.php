<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cines;

class CineSeeder extends Seeder
{
    public function run()
    {
        // Crear cines
        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Madrid',
            'direccion' => 'Calle Gran Vía, 1',
            'cantidad_salas' => 5,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Barcelona',
            'direccion' => 'Avenida Diagonal, 45',
            'cantidad_salas' => 3,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Sevilla',
            'direccion' => 'Plaza Nueva, 10',
            'cantidad_salas' => 4,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Valencia',
            'direccion' => 'Calle Colón, 12',
            'cantidad_salas' => 6,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Bilbao',
            'direccion' => 'Gran Vía, 20',
            'cantidad_salas' => 4,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Málaga',
            'direccion' => 'Calle Larios, 5',
            'cantidad_salas' => 3,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Zaragoza',
            'direccion' => 'Paseo Independencia, 8',
            'cantidad_salas' => 5,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Granada',
            'direccion' => 'Calle Reyes Católicos, 15',
            'cantidad_salas' => 4,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Alicante',
            'direccion' => 'Avenida Maisonnave, 22',
            'cantidad_salas' => 3,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Córdoba',
            'direccion' => 'Calle Cruz Conde, 9',
            'cantidad_salas' => 4,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Valladolid',
            'direccion' => 'Plaza Mayor, 3',
            'cantidad_salas' => 5,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Vigo',
            'direccion' => 'Calle Príncipe, 7',
            'cantidad_salas' => 3,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Gijón',
            'direccion' => 'Calle Corrida, 11',
            'cantidad_salas' => 4,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Santander',
            'direccion' => 'Paseo Pereda, 14',
            'cantidad_salas' => 3,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Pamplona',
            'direccion' => 'Avenida Carlos III, 18',
            'cantidad_salas' => 4,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Salamanca',
            'direccion' => 'Plaza Mayor, 6',
            'cantidad_salas' => 5,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'San Sebastián',
            'direccion' => 'Boulevard, 10',
            'cantidad_salas' => 3,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Burgos',
            'direccion' => 'Calle Vitoria, 25',
            'cantidad_salas' => 4,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Almería',
            'direccion' => 'Paseo de Almería, 12',
            'cantidad_salas' => 3,
        ]);

        Cines::create([
            'nombre' => 'SpainCinema',
            'localidad' => 'Tarragona',
            'direccion' => 'Rambla Nova, 30',
            'cantidad_salas' => 4,
        ]);
    }
}