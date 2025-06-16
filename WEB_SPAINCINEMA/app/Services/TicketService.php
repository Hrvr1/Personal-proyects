<?php

namespace App\Services;

use App\Models\Peliculas;
use App\Models\Tickets;
use App\Models\Salas;
use Carbon\Carbon;
use App\Models\Notificacion;
use App\Models\Asientos;
use Illuminate\Support\Facades\DB;

class TicketService
{
    public static function generarRecordatorio()
    {
        $tickets = Tickets::with(['sala.cine', 'usuario', 'pelicula'])
            ->whereDate('fecha_hora', Carbon::now()->addDay()->toDateString())->get();

        foreach ($tickets as $ticket) {
            $fechaHora = Carbon::parse($ticket->fecha_hora);

            $cineId = $ticket->sala->cine->id;

            $mensaje = "Hola {$ticket->usuario->nombre}, tienes una entrada para '{$ticket->pelicula->nombre}' en {$ticket->sala->cine->localidad}, sala {$ticket->sala_id}, mañana a las {$fechaHora->format('H:i')}.";

            $existeNotificacion = Notificacion::where('cine_id', $cineId)
                ->where('tipo', 'Recordatorio')
                ->where('correo', $ticket->usuario->email)
                ->where('mensaje', $mensaje)
                ->exists();

            if (!$existeNotificacion) {
                Notificacion::create([
                    'cine_id' => $cineId,
                    'tipo' => 'Recordatorio',
                    'nombre' => $ticket->usuario->nombre,
                    'correo' => $ticket->usuario->email,
                    'mensaje' => $mensaje,
                    'ticket_id' => $ticket->id,
                ]);
            }
        }
    }

    public static function procesarPago($user, $salaId, $peliculaId, $funcionData, $asientosSeleccionados, $total)
    {
        DB::beginTransaction();

        try {
            if (strpos($funcionData, '|') !== false) {
                $funcionParts = explode('|', $funcionData);
                if (count($funcionParts) === 2) {
                    [$funcionId, $fechaHora] = $funcionParts;
                } else {
                    throw new \Exception('Datos de la función inválidos.');
                }
            } else {
                throw new \Exception('Datos de la función inválidos.');
            }

            if (!is_array($asientosSeleccionados)) {
                $asientosSeleccionados = explode(',', $asientosSeleccionados);
            }

            $cineId = Salas::findOrFail($salaId)->cine_id;

            $pelicula = Peliculas::findOrFail($peliculaId);
            
            if ($pelicula->esEstreno()) {
                $estado = Tickets::ESTADO_RESERVADO;
            } else {
                $estado = Tickets::ESTADO_COMPRADO;
            }

            foreach ($asientosSeleccionados as $asiento) {
                $ticket = Tickets::create([
                    'user_id' => $user->id,
                    'sala_id' => $salaId,
                    'pelicula_id' => $peliculaId,
                    'fecha_hora' => $fechaHora,
                    'asiento' => $asiento,
                    'precio' => $total / count($asientosSeleccionados),
                    'estado' => $estado,
                    'fecha_reserva_expiracion' => null,
                ]);

                $sala = Salas::findOrFail($salaId);
                
                if ($estado == Tickets::ESTADO_COMPRADO){
                Notificacion::create([
                    'cine_id' => $cineId,
                    'tipo' => 'Compra',
                    'nombre' => $user->nombre,
                    'correo' => $user->email,
                    'mensaje' => "Has comprado un ticket para {$pelicula->nombre} en la sala {$sala->numero}.",
                    'ticket_id' => $ticket->id,
                ]);
            }else if ($estado == Tickets::ESTADO_RESERVADO){
                Notificacion::create([
                    'cine_id' => $cineId,
                    'tipo' => 'Reserva',
                    'nombre' => $user->nombre,
                    'correo' => $user->email,
                    'mensaje' => "Has reservado un ticket para {$pelicula->nombre} en la sala {$sala->numero}.",
                    'ticket_id' => $ticket->id,
                ]);
            }

                Asientos::create([
                    'sala_pelicula_id' => $funcionId,
                    'numero' => $asiento,
                ]);
            }

            DB::commit();

            self::generarRecordatorio();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Error al procesar el pago: " . $e->getMessage());
        }
    }
}
