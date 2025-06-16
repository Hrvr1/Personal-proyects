<?php
namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminTest extends TestCase
{

    public function testExample()
    {
        $user = User::create([
            'nombre' => 'ejemploAdmin',
            'apellidos' => 'ApellidosAdmin',
            'email' => 'adminejemplo@gmail.com',
            'password' => Hash::make('admin123'),
            'tarjeta' => '0000-1111-2222-3333',
        ]);

        $admin = Admin::create([
            'admin_id' => $user->id,
        ]);

          $this->assertEquals($user->id, $admin->admin_id);
          $this->assertDatabaseHas('users', [
              'id' => $user->id,
              'email' => 'adminejemplo@gmail.com',
          ]);
          $this->assertDatabaseHas('admins', [
              'admin_id' => $user->id,
          ]);
        $admin->delete();
        $user->delete();
    }
}