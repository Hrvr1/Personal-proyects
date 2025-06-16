<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cines;

class Notificacion extends Model
{
    use HasFactory;
    protected $table = 'notificaciones';
    protected $fillable = [
        'cine_id',
        'tipo',
        'nombre',
        'correo',
        'telefono',
        'mensaje',
        'respuesta',
        'leida',
        'ticket_id',
    ];

    public function cine()
    {
        return $this->belongsTo(Cines::class, 'cine_id');
    }
    public function ticket()
    {
        return $this->belongsTo(Tickets::class, 'ticket_id');
    }
}