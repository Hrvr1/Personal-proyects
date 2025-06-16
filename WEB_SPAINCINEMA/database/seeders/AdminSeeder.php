<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'nombre' => 'admin',
            'apellidos' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'tarjeta' => '0000-1111-2222-3333',
        ]);

        // Crea  admin asociado al usuario
        Admin::create([
            'admin_id' => $user->id,
        ]);
    }
}
            