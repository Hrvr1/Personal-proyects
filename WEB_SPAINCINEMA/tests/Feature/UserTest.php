<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function testExample(){
        $user = new User();
        $user->nombre = 'Nombre';
        $user->apellidos = 'Apellidos';
        $user->email = 'email@ejemplo.com';
        $user->password = 'password';
        $user->tarjeta = '1234567890123456';

        $this->assertEquals($user->nombre, 'Nombre');
        $this->assertEquals($user->apellidos, 'Apellidos');
        $this->assertEquals($user->email, 'email@ejemplo.com');

        $user->delete();    
    }
}
?>