<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nombre' => 'Juan',
            'apellidos' => 'Pérez',
            'email' => 'juan@gmail.com',
            'password' => Hash::make('password123'),
            'tarjeta' => '1234-5678-9123-4567',
        ]);

        User::factory(10)->create();
    }
}
