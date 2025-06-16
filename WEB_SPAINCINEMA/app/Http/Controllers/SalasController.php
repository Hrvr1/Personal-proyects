<?php

namespace App\Http\Controllers;

use App\Models\Salas;
use Illuminate\Http\Request;
use App\Models\Cines;


class SalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $allCines = Cines::all();
        $cineId = $request->input('cine_id');
        if ($cineId) {
            $cines = Cines::where('id', $cineId)->with('salas')->paginate(10);
        } else {
            $cines = Cines::with('salas')->paginate(3);
        }
        return view('salas', compact('cines', 'allCines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create_salas');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numero' => 'required|integer|min:1',
            'capacidad' => 'required|integer|min:1',
            'cine_id' => 'required|integer|min:1',
        ]);

        //El cine tiene que existir
        $cine = Cines::find($request->cine_id);
        if (!$cine) {
            return redirect()->back()->withErrors(['cine_id' => 'El cine especificado no existe.'])->withInput();
        }

        // Verifico que no exista otra sala con ese número en el mismo cine
        $existeSala = Salas::where('cine_id', $request->cine_id)
            ->where('numero', $request->numero)
            ->exists();

        if ($existeSala) {
            return redirect()->back()->withErrors(['numero' => 'Ya existe una sala con ese número en el cine seleccionado.'])->withInput();
        }
        Salas::create($validatedData);
        // Redirigir al listado de salas con un mensaje de éxito
        return redirect()->route('salas.index')->with('success', 'Sala añadido exitosamente.');
    }


    public function show(string $id)
    {
        $salas = Salas::findOrFail($id);
        return response()->json($salas);
    }

    public function edit(string $id)
    {
        $sala = Salas::findOrFail($id);
        return view('edit_salas', compact('sala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([

            'capacidad' => 'required|integer|min:1',

        ]);
        $sala = Salas::findOrFail($id);
        $sala->update($validatedData);

        return redirect()->route('salas.index')->with('success', 'Sala actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sala = Salas::findOrFail($id);
        $sala->delete();

        return redirect()->route('salas.index')->with('success', 'Sala eliminada exitosamente.');
    }

    public function peliculas($id)
    {
        $sala = Salas::findOrFail($id);

        // Obtener solo las películas asociadas a la sala
        $peliculas = $sala->peliculas()->paginate(10);

        return view('peliculas_sala', compact('sala', 'peliculas'));
    }

}