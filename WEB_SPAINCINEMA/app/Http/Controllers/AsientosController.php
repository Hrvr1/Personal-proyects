<?php
namespace App\Http\Controllers;
use App\Services\AsientosService;
use Illuminate\Http\Request;

class AsientosController extends Controller
{

    public function show($sala_id)
    {
        $funcionData = request('funcion_id');
        $cantidadTickets = request('cantidad', 1);

        $datos = AsientosService::obtenerDatosAsientos($sala_id, $funcionData, $cantidadTickets);

        if (isset($datos['error'])) {
            return redirect()->route('index')->with('error', $datos['error']);
        }

        return view('asientos', $datos);
    }

    public function reservar(Request $request)
    {
        $asientosSeleccionados = $request->input('asientos');
        $salaPeliculaId = $request->input('sala_pelicula_id');

        if (empty($asientosSeleccionados)) {
            return redirect()->route('asientos.show', ['sala_id' => $request->input('sala_id')])
                ->with('error', 'Debes seleccionar al menos un asiento.');
        }

        $reservado = AsientosService::reservarAsientos($asientosSeleccionados, $salaPeliculaId);

        if (!$reservado) {
            return redirect()->back()->with('error', 'No se pudo reservar los asientos. Intenta nuevamente.');
        }

        return redirect()->route('metodo.pago', [
            'sala_pelicula_id' => $salaPeliculaId,
            'asientos' => implode(',', $asientosSeleccionados),
        ]);
    }
}