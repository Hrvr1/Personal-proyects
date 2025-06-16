<?php

namespace App\Http\Controllers;

use App\Models\Cines;
use Illuminate\Http\Request;

class CinesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cines::withCount('peliculas'); 
        // Filtrar por localidad si se proporciona
        if ($request->has('localidad') && $request->localidad != '') {
            $query->where('localidad', 'like', '%' . $request->localidad . '%');
        }

        // Paginación de 10 cines por página
        $cines = $query->paginate(10);

        return view('cines', compact('cines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create_cines');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'localidad' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'cantidad_salas' => 'required|integer|min:1', // Validación para que sea mayor o igual a 1
        ]);

        // Forzar el nombre a "SpainCinema"
        $validatedData['nombre'] = 'SpainCinema';

        // Crear el cine
        Cines::create($validatedData);

        // Redirigir al listado de cines con un mensaje de éxito
        return redirect()->route('cines.index')->with('success', 'Cine añadido exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cines = Cines::findOrFail($id); // Busca el cines por ID
        return response()->json($cines); // Devuelve el cines como JSON
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(string $id)
    {
        $cine = Cines::findOrFail($id); // Cambiar $cines a $cine
        return view('edit_cines', compact('cine')); // Pasar la variable $cine a la vista
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'localidad' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'cantidad_salas' => 'required|integer|min:1',
        ]);

        // Buscar el cine por ID y actualizarlo
        $cine = Cines::findOrFail($id);
        $cine->update($validatedData);

        // Redirigir al listado de cines con un mensaje de éxito
        return redirect()->route('cines.index')->with('success', 'Cine actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cine = Cines::findOrFail($id);
        $cine->delete();

        return redirect()->route('cines.index')->with('success', 'Cine eliminado exitosamente.');
    }

    public function peliculas($id)
    {
        $cine = Cines::findOrFail($id);

        // Obtener solo las películas asociadas al cine
        $peliculas = $cine->peliculas()->paginate(10);

        return view('peliculas_cine', compact('cine', 'peliculas'));
    }
}