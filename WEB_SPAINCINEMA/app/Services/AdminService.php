<?php

namespace App\Services;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\Peliculas;
use App\Models\Cines;
use Carbon\Carbon;

class AdminService
{
    public static function createAdmin($data)
    {
        $rollback = false;
        DB::beginTransaction();
        $admin = null;

        try {
            $user = new User();
            $user->nombre = $data['nombre'];
            $user->apellidos = $data['apellidos'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();

            $admin = new Admin();
            $admin->admin_id = $user->id;
            $admin->save();
        } catch (\Exception $e) {
            $rollback = true;
        }

        if ($rollback) {
            DB::rollBack();
            return null;
        }
        DB::commit();
        return $admin;
    }

    public static function asignarAdmin($userId)
    {
        $rollback = false;
        DB::beginTransaction();
        $admin = null;

        try {
            $usuario = User::find($userId);

            if (!$usuario) {
                $rollback = true;
            } elseif (method_exists($usuario, 'isAdmin') && $usuario->isAdmin()) {
                $rollback = true;
            } else {
                $admin = new Admin();
                $admin->admin_id = $usuario->id;
                $admin->save();
                $usuario->save();
            }
        } catch (\Exception $e) {
            $rollback = true;
        }

        if ($rollback) {
            DB::rollBack();
            return null;
        }
        DB::commit();
        return $admin;
    }

    public static function getCinesYPeliculas($peliculaId = null)
    {
        $rollback = false;
        DB::beginTransaction();
        $result = null;

        try {
            $cines = Cines::with('salas')->get();
            $peliculas = Peliculas::all();
            $result = compact('cines', 'peliculas', 'peliculaId');
        } catch (\Exception $e) {
            $rollback = true;
        }

        if ($rollback) {
            DB::rollBack();
            return null;
        }
        DB::commit();
        return $result;
    }

    public static function asociarPeliculaACine($peliculaId, $cineId)
    {
        $rollback = false;
        DB::beginTransaction();
        $result = null;

        try {
            $cine = Cines::find($cineId);
            if (!$cine) {
                $rollback = true;
                $result = ['success' => false, 'msg' => 'Cine no encontrado.'];
            } else {
                $exists = DB::table('cine_pelicula')
                    ->where('cine_id', $cine->id)
                    ->where('pelicula_id', $peliculaId)
                    ->exists();

                if ($exists) {
                    $rollback = true;
                    $result = ['success' => false, 'msg' => 'La película ya está asociada a este cine.'];
                } else {
                    $cine->peliculas()->attach($peliculaId);
                    $result = ['success' => true];
                }
            }
        } catch (\Exception $e) {
            $rollback = true;
            $result = ['success' => false, 'msg' => 'Error en la operación.'];
        }

        if ($rollback) {
            DB::rollBack();
            return $result;
        }
        DB::commit();
        return $result;
    }

    public static function getDatosCrearSesion()
    {
        $rollback = false;
        DB::beginTransaction();
        $result = null;

        try {
            $cines = Cines::with(['salas', 'peliculas'])->get();
            $datosPorCine = $cines->mapWithKeys(function ($cine) {
                return [
                    $cine->id => [
                        'peliculas' => $cine->peliculas->map(function ($p) {
                            return ['id' => $p->id, 'nombre' => $p->nombre];
                        })->values(),
                        'salas' => $cine->salas->map(function ($sala) {
                            return ['id' => $sala->id, 'numero' => $sala->numero];
                        })->values(),
                    ]
                ];
            });
            $result = compact('cines', 'datosPorCine');
        } catch (\Exception $e) {
            $rollback = true;
        }

        if ($rollback) {
            DB::rollBack();
            return null;
        }
        DB::commit();
        return $result;
    }

    public static function guardarSesion($data)
    {
        $rollback = false;
        DB::beginTransaction();

        try {
            $pelicula = Peliculas::findOrFail($data['pelicula_id']);
            $inicio = Carbon::parse("{$data['fecha']} {$data['hora']}");
            $fin = $inicio->copy()->addMinutes($pelicula->duracion);

            $sesiones = DB::table('sala_pelicula')
                ->where('sala_id', $data['sala_id'])
                ->get();

            foreach ($sesiones as $sesion) {
                $inicioSesion = Carbon::parse($sesion->fecha_hora);
                $peliculaSesion = Peliculas::find($sesion->pelicula_id);
                $finSesion = $inicioSesion->copy()->addMinutes($peliculaSesion->duracion);

                $haySolape = $inicio->between($inicioSesion, $finSesion) ||
                    $fin->between($inicioSesion, $finSesion) ||
                    ($inicio <= $inicioSesion && $fin >= $finSesion);

                if ($haySolape) {
                    $rollback = true;
                    break;
                }
            }

            if (!$rollback) {
                DB::table('sala_pelicula')->insert([
                    'pelicula_id' => $pelicula->id,
                    'sala_id' => $data['sala_id'],
                    'fecha_hora' => $inicio,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            $rollback = true;
        }

        if ($rollback) {
            DB::rollBack();
            return [
                'success' => false,
                'msg' => 'Hubo un error al crear la sesión.'
            ];
        }
        DB::commit();
        return [
            'success' => true,
            'msg' => 'Sesión creada correctamente.'
        ];
    }
}