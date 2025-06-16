<?php

namespace Database\Seeders;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            CineSeeder::class,
            SalasSeeder::class,
            PeliculasSeeder::class,
            CinePeliculaSeeder::class,
            FuncionesSeeder::class,
            TicketsSeeder::class,
            AsientosSeeder::class,
            ReviewSeeder::class,
        ]);

        Artisan::call('storage:link');
        Artisan::call('recordatorio:generar');
    }
}
