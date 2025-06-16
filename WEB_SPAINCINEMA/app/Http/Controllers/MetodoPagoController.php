<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SalaPelicula;
use App\Services\TicketService;

class MetodoPagoController extends Controller
{

    protected $ticketService;
    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index(Request $request)
    {
        $salaPelicula = SalaPelicula::findOrFail($request->input('sala_pelicula_id'));
        $pelicula = $salaPelicula->pelicula;
        $sala = $salaPelicula->sala;
        $fechaHora = $salaPelicula->fecha_hora;

        $asientosSeleccionados = $request->input('asientos', []); 
        $cantidadTickets = count($asientosSeleccionados);
        $precioPorAsiento = $pelicula->precio; 
        $total = $precioPorAsiento * $cantidadTickets;

        if (empty($asientosSeleccionados)) {
            return redirect()->route('asientos.show', ['sala_id' => $sala->id])
                ->with('error', 'Debes seleccionar al menos un asiento.');
        }

        $user = Auth::user();
        $tarjetaGuardada = $user->tarjeta ?? null;

        return view('metodopago', compact('pelicula', 'sala', 'asientosSeleccionados', 'precioPorAsiento', 'total', 'fechaHora', 'salaPelicula', 'tarjetaGuardada'));
    }

    public function procesar(Request $request)
    {
        $user = Auth::user();
        $salaId = $request->input('sala_id');
        $peliculaId = $request->input('pelicula_id');
        $fechaHora = $request->input('fecha_hora');
        $asientosSeleccionados = $request->input('asientos');
        $total = $request->input('total');
    
        try {
            $this->ticketService->procesarPago($user, $salaId, $peliculaId, $fechaHora, $asientosSeleccionados, $total);
            return redirect()->route('index')->with('success', 'Pago procesado y tickets generados correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}