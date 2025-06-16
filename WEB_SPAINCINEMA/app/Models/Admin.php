<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends User
{
    //Usuarios administradores que pueden dar altas y bajas a clientes y pelis
    protected $fillable = [
        'admin_id',
    ];
}
