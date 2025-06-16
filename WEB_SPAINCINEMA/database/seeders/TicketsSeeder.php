<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Salas;
use App\Models\Peliculas;
use App\Models\Tickets;
use Carbon\Carbon;

class TicketsSeeder extends Seeder
{
    public function run(): void
    {
        $peliculas = Peliculas::all();
        $usuarios = range(1, 10);

        foreach ($usuarios as $userId) {
            $cantidadPeliculas = $peliculas->count();
            $peliculasSeleccionadas = $cantidadPeliculas >= 11
                ? $peliculas->random(11)
                : $peliculas;

            foreach ($peliculasSeleccionadas as $pelicula) {
                if ($pelicula->salas->isEmpty()) {
                    continue;
                }

                $sala = $pelicula->salas->random();
                $fechaHora = $sala->pivot->fecha_hora;
                $asiento = rand(1, $sala->capacidad);

                $estado = collect([
                    Tickets::ESTADO_COMPRADO,
                    Tickets::ESTADO_RESERVADO,
                ])->random();

                $fechaReservaExp = $estado === Tickets::ESTADO_RESERVADO
                    ? Carbon::now()->addMinutes(30)
                    : null;

                Tickets::create([
                    'asiento' => $asiento,
                    'user_id' => $userId,
                    'pelicula_id' => $pelicula->id,
                    'sala_id' => $sala->id,
                    'precio' => $pelicula->precio,
                    'fecha_hora' => $fechaHora,
                    'estado' => $estado,
                    'fecha_reserva_expiracion' => $fechaReservaExp
                ]);
            }
        }
    }
}
