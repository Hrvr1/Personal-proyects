<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Asientos;

class TicketsController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el usuario autenticado
        $userId = Auth::id();

        // Filtrar los tickets por el usuario autenticado
        $query = Tickets::where('user_id', $userId)
        ->where('estado', Tickets::ESTADO_COMPRADO);// Aqui filtro por los tickets comprados 

        // Filtro opcional por película
        if ($request->filled('pelicula')) {
            $query->whereHas('pelicula', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->pelicula . '%');
            });
        }

        // Ordenar por fecha 
        if ($request->input('ordenar') === 'fecha') {
            $direccion = $request->input('direccion', 'asc'); // ascendente
            $query->orderBy('fecha_hora', $direccion);
        }

        // Paginación
        $tickets = $query->with('pelicula')->paginate(9);

        return view('tickets', compact('tickets'));
    }
    

    public function ver_reservas(Request $request)
    {
        $userId = Auth::id();
    
        $query = Tickets::where('user_id', $userId)
            ->where('estado', Tickets::ESTADO_RESERVADO);
            
        if ($request->filled('pelicula')) {
            $query->whereHas('pelicula', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->pelicula . '%');
            });
        }
    
        if ($request->input('ordenar') === 'fecha') {
            $direccion = $request->input('direccion', 'asc');
            $query->orderBy('fecha_hora', $direccion);
        }
    
        $reservas = $query->with('pelicula')->paginate(9);
    
        return view('reservas', compact('reservas'));
    }

    public function mostrar_info(string $id)
    {
        $ticket = Tickets::findOrFail($id); 
        return view('ver_ticket', ['ticket' => $ticket]);
    }

    public function mostrar_tickets(string $id_usuario)
    {
        $tickets = Tickets::where('user_id', '=', $id_usuario)
        ->where('estado', Tickets::ESTADO_COMPRADO)
        ->get();
        return $tickets;
    }

    public function borrar(string $id)
    {
        $ticket = Tickets::findOrFail($id);

        if ($ticket->asiento) {
            Asientos::where('numero', $ticket->asiento)
                ->whereIn('sala_pelicula_id', function ($query) use ($ticket) {
                    $query->select('id')
                        ->from('sala_pelicula') 
                        ->where('sala_id', $ticket->sala_id)
                        ->where('fecha_hora', $ticket->fecha_hora);
                })
                ->delete();
        }

        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'El ticket y su asiento asociado han sido eliminados correctamente.');
    }

    public function modificar_ticket(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'required|integer',
            'id_pelicula' => 'required|integer',
            'id_sala' => 'required|integer',
            'fecha' => 'required|date',
            'hora' => 'required|time',
            'precio' => 'required|numeric',
        ]);

        $ticket = Tickets::findOrFail($id); 
        $ticket->user_id = $validatedData['id_usuario']; 
        $ticket->pelicula_id = $validatedData['id_pelicula']; 
        $ticket->sala_id = $validatedData['id_sala']; 
        $ticket->fecha_hora = Carbon::parse($validatedData['fecha'] . ' ' . $validatedData['hora']); 
        $ticket->precio = $validatedData['precio'];
        $ticket->save();

        return redirect('/tickets')->with('success', 'Ticket modificado correctamente');
    }
}
