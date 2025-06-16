<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Cines;
use Illuminate\Support\Facades\Auth;
use App\Services\AdminService;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Admin::all();
        return $usuarios;
    }


    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $admin = AdminService::createAdmin($validatedData);
        if (!$admin) {
            return redirect()->route('usuarios.index')->with('error', 'Error al crear el administrador.');
        }
        return redirect()->route('usuarios.index')->with('success', 'Administrador creado correctamente.');
    }

    public function asignarAdmin($id)
    {
        $admin = AdminService::asignarAdmin($id);

        if (!$admin) {
            return redirect()->route('usuarios.index')->with('error', 'No se pudo asignar el rol de administrador. El usuario no existe o ya es administrador.');
        }

        return redirect()->route('usuarios.index')->with('success', 'El usuario ha sido asignado como administrador.');
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return redirect('/')->with('error', 'No puedes desasignarte a ti mismo como administrador.');
        }
        $admin = Admin::where('admin_id', $id)->first();
        if (!$admin) {
            return redirect()->route('usuarios.index')->with('error', 'El usuario no tiene el rol de administrador.');
        }
        $admin->delete();
        return redirect()->route('usuarios.index')->with('success', 'El rol de administrador ha sido desasignado correctamente.');
    }

    public function asociarPeliculas($peliculaId = null)
    {
        $data = AdminService::getCinesYPeliculas($peliculaId);
        return view('asociar_peliculas', $data);
    }

    public function desasociarPelicula(Request $request)
    {
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id',
            'cine_id' => 'required|exists:cines,id',
        ]);

        $cine = Cines::findOrFail($request->cine_id);
        $exists = $cine->peliculas()->where('pelicula_id', $request->pelicula_id)->exists();

        if (!$exists) {
            return redirect()->route('cines.peliculas', $cine->id)->with('error', 'La película no está asociada a este cine.');
        }
        $cine->peliculas()->detach($request->pelicula_id);
        return redirect()->route('cines.peliculas', $cine->id)->with('success', 'Película desasociada correctamente del cine.');
    }

    public function guardarAsociacion(Request $request)
    {
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id',
            'cine_id' => 'required|exists:cines,id',
        ]);

        $result = AdminService::asociarPeliculaACine($request->pelicula_id, $request->cine_id);

        if (!$result['success']) {
            return back()->with('error', $result['msg']);
        }

        return back()->with('success', 'Película asociada correctamente al cine.');
    }

    public function crearSesion()
    {
        $data = AdminService::getDatosCrearSesion();
        return view('crear_sesion', $data);
    }

    public function guardarSesion(Request $request)
    {
        try {
            $request->validate([
                'pelicula_id' => 'required|exists:peliculas,id',
                'sala_id' => 'required|exists:salas,id',
                'fecha' => 'required|date',
                'hora' => 'required|date_format:H:i',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', 'Error de validación: ' . $e->getMessage());
        }

        $result = AdminService::guardarSesion($request->all());

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['msg']);
        }
        return redirect()->back()->with('success', 'Sesión creada correctamente.');
    }

}
