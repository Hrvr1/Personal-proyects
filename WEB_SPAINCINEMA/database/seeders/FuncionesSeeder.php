<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peliculas;
use App\Models\Salas;

class FuncionesSeeder extends Seeder
{
    public function run(): void
    {
        $peliculas = Peliculas::all();

        // Filtrar salas solo de los cines con ID 1 y 2
        $salasPorCine = Salas::with('cine')
            ->whereIn('cine_id', [1, 2]) 
            ->get()
            ->groupBy('cine_id');

        foreach ($salasPorCine as $cineId => $salas) {
            foreach ($peliculas as $pelicula) {
                $salasAsignadas = $salas->take(4);

                foreach ($salasAsignadas as $sala) {
                    $horarios = $this->generarHorariosAleatorios(1);

                    foreach ($horarios as $hora) {
                        $fechaHora = now()->addDays(rand(1, 7))->setTimeFromTimeString($hora);

                        $sala->peliculas()->attach($pelicula->id, [
                            'fecha_hora' => $fechaHora,
                        ]);
                    }
                }
            }
        }
    }

    private function generarHorariosAleatorios(int $cantidad): array
    {
        $horarios = [];
        while (count($horarios) < $cantidad) {
            $hora = str_pad(rand(9, 23), 2, '0', STR_PAD_LEFT); 
            $minuto = str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT); 
            $horario = "$hora:$minuto";

            // Evitar horarios duplicados
            if (!in_array($horario, $horarios)) {
                $horarios[] = $horario;
            }
        }
        return $horarios;
    }
}