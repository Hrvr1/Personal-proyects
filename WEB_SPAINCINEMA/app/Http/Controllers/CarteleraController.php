<?php

namespace App\Http\Controllers;
use App\Services\CarteleraService;
use Illuminate\Http\Request;

class CarteleraController extends Controller
{
    public function cartelera(Request $request, $cine_id = null)
    {
        return $this->listarPeliculas($request, $cine_id, 'cartelera');
    }

    public function estrenos(Request $request, $cine_id = null)
    {
        return $this->listarPeliculas($request, $cine_id, 'estrenos');
    }

    private function listarPeliculas(Request $request, $cine_id, $tipo)
    {
        $peliculas = CarteleraService::listarPeliculas($request, $cine_id, $tipo);

        if ($peliculas['redirect']) {
            return redirect()->route($peliculas['route'])->with('error', $peliculas['error']);
        }

        $vista = $tipo === 'cartelera' ? 'cartelera' : 'estrenos';
        return view($vista, [
            'cine' => $peliculas['cine'],
            'peliculas' => $peliculas['peliculas'],
            'generos' => $peliculas['generos']
        ]);
    }
}