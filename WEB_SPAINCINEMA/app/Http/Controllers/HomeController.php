<?php

namespace App\Http\Controllers;

use App\Models\Peliculas;
use App\Models\Cines;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener la fecha actual
        $hoy = Carbon::today();

        // Filtrar las películas con fecha de estreno posterior a hoy
        $peliculas = Peliculas::where('fecha_estreno', '>', $hoy)->get();

        // Obtener todos los cines
        $cines = Cines::all();

        // Retornar la vista con las películas y cines
        return view('index', compact('peliculas', 'cines'));
    }
}