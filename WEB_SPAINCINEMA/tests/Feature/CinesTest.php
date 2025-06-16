<?php
namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cines;

class CinesTest extends TestCase
{
    public function testExample(){
        $cines = new Cines();
        $cines->nombre = 'Cines';
        $cines->direccion = 'Direccion';
        $cines->localidad = 'Ciudad';
        $cines->cantidad_salas = 5;

        $this->assertEquals($cines->nombre, 'Cines');
        $this->assertEquals($cines->direccion, 'Direccion');
        $this->assertEquals($cines->localidad, 'Ciudad');
        $this->assertEquals($cines->cantidad_salas, 5);

        $cines->delete();
    }
}

