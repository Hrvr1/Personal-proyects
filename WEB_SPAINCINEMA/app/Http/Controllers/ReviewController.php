<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id',
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);
    
       Review::create([
            'pelicula_id' => $request->pelicula_id,
            'user_id' => auth()->id(),
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);
    
        return back()->with('success', '¡Gracias por tu reseña!');
    }   

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
    
        return back()->with('success', 'Reseña eliminada con éxito.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);
    
        $review = Review::findOrFail($id);
        $review->update([
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);
    
        return back()->with('success', 'Reseña actualizada con éxito.');
    }

    
}
