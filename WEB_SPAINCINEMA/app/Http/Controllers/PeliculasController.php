<?php

namespace App\Http\Controllers;

use App\Models\Peliculas;
use Illuminate\Http\Request;
use App\Models\Cines;
use App\Models\Salas;
use Illuminate\Support\Facades\Storage;
use App\Services\PeliculasService;

class PeliculasController extends Controller
{

    public function index(Request $request)
    {
        $query = Peliculas::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('genero')) {
            $query->where('genero', 'like', '%' . $request->genero . '%');
        }

        if ($request->filled('ordenar')) {
            $query->orderBy('fecha_estreno', $request->ordenar);
        }

        $peliculas = $query->paginate(8);

        $generos = Peliculas::distinct()->pluck('genero');

        return view('gestionar_peliculas', compact('peliculas', 'generos'));
    }


    public function create()
    {
        $salas = Salas::with('cine')->get();
        $cines = Cines::all(); 
    
        return view('create_peliculas', compact('salas', 'cines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_estreno' => 'required|date',
            'precio' => 'required|numeric|min:0',
            'genero' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'duracion' => 'required|integer|min:1',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer' => 'nullable|url|max:255',
        ]);
    
        $data = $request->except('imagen');
    
        // Procesar imagen
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('imagenes', 'public');
            $data['imagen'] = basename($imagePath);
        }
    
        Peliculas::create($data);
    
        return redirect()->route('peliculas.gestionar')->with('success', 'Película creada correctamente');
    }
    
    public function show($id, $cine_id)
    {
        $pelicula = Peliculas::with(['reviews.user', 'salas'])->findOrFail($id);
        $cine = Cines::findOrFail($cine_id);

        $sala = $pelicula->salas()->where('cine_id', $cine_id)->first();

        if (!$sala) {
            return redirect()->route('index')->with('error', 'No se encontró una sala asociada para esta película en el cine seleccionado.');
        }

        $precio = $pelicula->precio ?? 7.50; 

        return view('peliculas.show', compact('pelicula', 'cine', 'sala', 'precio'));
    }

    public function edit($id)
    {
        $pelicula = Peliculas::with(['salas.cine'])->findOrFail($id);
        $cines = Cines::all();
        $cineActual = $pelicula->salas->first()->cine_id ?? null;
        $salas = Salas::with('cine')->get();

        return view('editar_peliculas', compact('pelicula', 'cines', 'salas', 'cineActual'));
    }

    public function update(Request $request, $id)
    {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'fecha_estreno' => 'required|date',
                'precio' => 'required|numeric|min:0',
                'genero' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'duracion' => 'required|integer|min:1',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'trailer' => 'nullable|url|max:255',
            ]);

            $pelicula = Peliculas::findOrFail($id);
            $data = $request->except('imagen');

            if ($request->hasFile('imagen')) {
                if ($pelicula->imagen && Storage::exists($pelicula->imagen)) {
                    Storage::delete($pelicula->imagen);
                }
                
                $imagePath = $request->file('imagen')->store('imagenes', 'public');
                $pelicula->imagen = $imagePath;
            }
            $pelicula->update($data);

        if ($request->hasFile('imagen')) {
            if ($pelicula->imagen) {
                Storage::disk('public')->delete('imagenes/' . $pelicula->imagen);
            }
            $imagePath = $request->file('imagen')->store('imagenes', 'public');
            $pelicula->imagen = basename($imagePath); // Guardar solo el nombre del archivo
        }
        $pelicula->save();
        return redirect()->route('peliculas.gestionar')->with('success', 'Película actualizada correctamente.');
    }
    

    public function destroy($id)
    {
        Peliculas::destroy($id);
        return redirect()->route('peliculas.gestionar')->with('success', 'Película eliminada');
    }

    public function gestionar(Request $request)
    {
        $search = $request->input('search');
        $genero = $request->input('genero');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $peliculas = Peliculas::when($search, function ($query, $search) {
            return $query->where('nombre', 'like', "%{$search}%");
        })
        ->when($genero, function ($query, $genero) {
            return $query->where('genero', $genero);
        })
        ->when($fechaInicio, function ($query, $fechaInicio) {
            return $query->where('fecha_estreno', '>=', $fechaInicio);
        })
        ->when($fechaFin, function ($query, $fechaFin) {
            return $query->where('fecha_estreno', '<=', $fechaFin);
        })
        ->paginate(10); 

        $generos = Peliculas::select('genero')->distinct()->pluck('genero');

        return view('gestionar_peliculas', compact('peliculas', 'generos'));
    }
    
}
