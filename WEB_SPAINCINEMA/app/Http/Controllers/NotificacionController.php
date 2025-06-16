<?php

namespace App\Http\Controllers;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            $notificaciones = Notificacion::where(function ($query) {
                $query->whereIn('tipo', ['General', 'Soporte'])
                      ->orWhere('correo', auth()->user()->email);
            })->get();
        } else {
            $notificaciones = Notificacion::where('correo', auth()->user()->email)->get();
        }
        return view('notificaciones', compact('notificaciones'));
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'cine' => 'required|exists:cines,id',
            'consulta' => 'required|in:General,Soporte',
            'nombre' => 'required|string|min:3|max:50',
            'correo' => 'required|email',
            'telefono' => 'nullable|digits:9',
            'mensaje' => 'required|string|min:3|max:500',
        ], [
            'cine.required' => 'Por favor, selecciona un cine.',
            'cine.exists' => 'El cine seleccionado no es válido.',
            'consulta.required' => 'Por favor, selecciona un tipo de consulta.',
            'consulta.in' => 'El tipo de consulta seleccionado no es válido.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Por favor, introduce un correo electrónico válido.',
            'telefono.digits' => 'El teléfono debe contener exactamente 9 dígitos.',
            'mensaje.required' => 'El mensaje es obligatorio.',
            'mensaje.min' => 'El mensaje debe tener al menos 10 caracteres.',
            'mensaje.max' => 'El mensaje no puede tener más de 500 caracteres.',
        ]);
    
        try {
            Notificacion::create([
                'cine_id' => $request->cine,
                'tipo' => $request->consulta,
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'mensaje' => $request->mensaje,
            ]);
    
            // Redirigir con un mensaje de éxito
            return redirect()->route('index')->with('success', 'Tu mensaje ha sido enviado correctamente.');
        } catch (\Exception $e) {
            // Redirigir con un mensaje de error
            return redirect()->route('index')->with('error', 'Ocurrió un error al enviar tu mensaje. Por favor, inténtalo de nuevo.');
        }
    }
    public function show($id)
    {
        $notificacion = Notificacion::findOrFail($id);

        if (!$notificacion->leida) {
            $notificacion->leida = true;
            $notificacion->save();
        }

        return view('ver_notificacion', compact('notificacion'));
    }

    public function destroy($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->delete();

        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada correctamente.');
    }
    public function responder(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|string|max:1000',
        ]);

        $notificacion = Notificacion::findOrFail($id);
        $notificacion->respuesta = $request->input('respuesta');
        $notificacion->save();

        return redirect()->route('notificaciones.index')->with('success', 'Respuesta enviada correctamente.');
    }

}