<?php

namespace App\Services;

use App\Models\Cines;
use App\Models\Peliculas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CarteleraService
{
    public static function listarPeliculas(Request $request, $cine_id, $tipo)
    {
        $rollback = false;
        DB::beginTransaction();
    
        try {
            if (is_null($cine_id)) {
                DB::rollBack();
                return [
                    'redirect' => true,
                    'route' => 'index',
                    'error' => 'Debes seleccionar un cine para ver la cartelera.'
                ];
            }
    
            $cine = Cines::find($cine_id);
    
            if (!$cine || $cine->cantidad_salas == 0) {
                DB::rollBack();
                return [
                    'redirect' => true,
                    'route' => 'index',
                    'error' => 'Debes seleccionar un cine válido para ver la cartelera.'
                ];
            }
    
            $query = Peliculas::whereHas('cines', function ($q) use ($cine) {
                $q->where('cines.id', $cine->id);
            })->whereHas('salas', function ($q) use ($cine) {
                $q->where('cine_id', $cine->id);
            });
    
            if ($tipo === 'cartelera') {
                $query->whereDate('fecha_estreno', '<=', now())->withAvg('reviews', 'puntuacion');
            } else {
                $query->whereDate('fecha_estreno', '>', now());
            }
    
            if ($request->filled('nombre')) {
                $query->where('nombre', 'like', '%' . $request->nombre . '%');
            }
    
            if ($request->filled('generos')) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->generos as $genero) {
                        $q->where('genero', 'like', '%' . $genero . '%');
                    }
                });
            }
    
            if ($request->filled('dia_sesion') || $request->filled('hora_sesion')) {
                $query->whereExists(function ($q) use ($cine, $request) {
                    $q->select(DB::raw(1))
                        ->from('sala_pelicula')
                        ->join('salas', 'sala_pelicula.sala_id', '=', 'salas.id')
                        ->whereRaw('sala_pelicula.pelicula_id = peliculas.id')
                        ->where('salas.cine_id', $cine->id);
    
                    if ($request->filled('dia_sesion')) {
                        $q->whereDate('sala_pelicula.fecha_hora', $request->dia_sesion);
                    }
                    if ($request->filled('hora_sesion')) {
                        $q->whereTime('sala_pelicula.fecha_hora', $request->hora_sesion);
                    }
                });
            }
    
            if ($request->filled('ordenar')) {
                $query->orderBy('fecha_estreno', $request->ordenar);
            }
    
            $peliculas = $query->paginate(8);
            $generos = Peliculas::pluck('genero')
                ->flatMap(function ($genero) {
                    return array_map('trim', explode(',', $genero));
                })->unique()->sort()->values();
    
            DB::commit();
            return [
                'redirect' => false,
                'cine' => $cine,
                'peliculas' => $peliculas,
                'generos' => $generos
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'redirect' => true,
                'route' => 'index',
                'error' => 'Ocurrió un error al obtener la cartelera.'
            ];
        }
    }
}