<?php

namespace App\Services;

use App\Models\Salas;
use App\Models\SalaPelicula;
use App\Models\Asientos;
use Illuminate\Support\Facades\DB;

class AsientosService
{
    public static function  obtenerDatosAsientos($sala_id, $funcionData, $cantidadTickets = 1)
    {
        $sala = Salas::with('cine')->findOrFail($sala_id);
        $fechaHora = $funcionData ? explode('|', $funcionData)[1] : null;

        if (!$fechaHora) {
            return ['error' => 'Datos de la función inválidos.'];
        }

        $pelicula = $sala->peliculas()->wherePivot('fecha_hora', $fechaHora)->first();

        if (!$pelicula) {
            return ['error' => 'Película no encontrada para la función seleccionada.'];
        }

        $salaPelicula = SalaPelicula::where('sala_id', $sala_id)
            ->where('pelicula_id', $pelicula->id)
            ->where('fecha_hora', $fechaHora)
            ->firstOrFail();

        $asientosOcupados = Asientos::where('sala_pelicula_id', $salaPelicula->id)->pluck('numero')->toArray();

        $capacidad = $sala->capacidad;
        $columnas = 10;
        $filas = ceil($capacidad / $columnas);
        $asientos = [];

        for ($fila = 1; $fila <= $filas; $fila++) {
            $asientosFila = [];
            for ($columna = 1; $columna <= $columnas; $columna++) {
                $asientoNumero = (($fila - 1) * $columnas) + $columna;
                if ($asientoNumero > $capacidad) break;
                $asientosFila[] = $asientoNumero;
            }
            $asientos[] = $asientosFila;
        }

        return compact('sala', 'pelicula', 'asientos', 'asientosOcupados', 'cantidadTickets', 'fechaHora', 'salaPelicula');
    }

    public static function reservarAsientos($asientosSeleccionados, $salaPeliculaId)
    {
        DB::beginTransaction();
        try {
            foreach ($asientosSeleccionados as $asiento) {
                Asientos::create([
                    'sala_pelicula_id' => $salaPeliculaId,
                    'numero' => $asiento,
                ]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}