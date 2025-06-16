<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query();

        // Filtrar por localidad si se proporciona
        if ($request->has('nombre') && $request->nombre != '') {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Paginación de 10 cines por página
        $usuarios = $query->paginate(10);

        return view('usuarios', compact('usuarios'));

    }

    public function registrar(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::factory()->create([
            'nombre' => $validatedData['nombre'],
            'apellidos' => $validatedData['apellidos'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Auth::login($user); // Loguear al usuario
        return redirect('/')->with('success', 'Usuario registrado correctamente');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $recordar = $request->has('remember');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $recordar)) {
            if ($recordar) {
                cookie()->queue('email', $request->email, 43200);
                cookie()->queue('password', $request->password, 43200);
                cookie()->queue('remember', true, 43200); //30 días
            } else {
                // Eliminar cookies 
                cookie()->queue(cookie()->forget('email'));
                cookie()->queue(cookie()->forget('password'));
                cookie()->queue(cookie()->forget('remember'));
            }

            return redirect('/');
        } else {
             // Eliminar cookies 
                cookie()->queue(cookie()->forget('email'));
                cookie()->queue(cookie()->forget('password'));
                cookie()->queue(cookie()->forget('remember'));
                return redirect('/login.post')->with(['error' => 'Credenciales incorrectas']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function ver_perfil()
    {
        $user = Auth::user();
        return view('perfil', compact('user'));
    }

    public function editar_perfil(Request $request, $id = null)
    {
        $user = $id ? User::find($id) : Auth::user(); 

        if (!$user) {
            return redirect('/perfil')->with('error', 'Usuario no encontrado');
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->nombre = $validatedData['nombre'];
        $user->apellidos = $validatedData['apellidos'];
        $user->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        if (Auth::id() == $user->id) {
            return redirect('/perfil')->with('success', 'Perfil actualizado correctamente');
        }
        return redirect()->route('usuarios.index')->with('success', 'Perfil actualizado correctamente');

    }

    public function borrar_perfil()
    {
        $user = Auth::user();
        $user->delete();

        return redirect('/')->with('success', 'Perfil borrado');
    }
    public function editar_metodos_pago(Request $request)
    {
        $request->validate([
            'password' => 'nullable|string',
            'numero' => 'nullable|string|max:19',
            'nombre_completo' => 'nullable|string|max:255',
            'direccion1' => 'nullable|string|max:255',
            'direccion2' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:255',
            'codigo_postal' => 'nullable|string|max:10',
            'telefono' => 'nullable|string|max:15',
        ]);

        $facturacion = implode(',', [
            $request->nombre_completo,
            $request->direccion1,
            $request->direccion2,
            $request->ciudad,
            $request->provincia,
            $request->codigo_postal,
            $request->telefono,
        ]);

        $user = Auth::user();
        if ($request->numero && $request->password) {
            $user->tarjeta = $request->numero;
        }
        $user->facturacion = $facturacion;
        $user->save();
        return redirect()->route('perfil')->with('success', 'Métodos de pago y facturación actualizados correctamente.');
    }
    public function mostrar_metodos_pago()
    {
        $user = Auth::user();
        $facturacion = $user->facturacion ? explode(',', $user->facturacion) : [];
        
        return view('editar_metodos_pago', [
            'facturacion' => [
                'nombre_completo' => $facturacion[0] ?? '',
                'direccion1' => $facturacion[1] ?? '',
                'direccion2' => $facturacion[2] ?? '',
                'ciudad' => $facturacion[3] ?? '',
                'provincia' => $facturacion[4] ?? '',
                'codigo_postal' => $facturacion[5] ?? '',
                'telefono' => $facturacion[6] ?? '',
            ],
        ]);
    }
    public function show($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado');
        }
        return view('perfil', ['user' => $usuario]);
    }

    public function edit($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado');
        }
        return view('editar_perfil', ['usuario' => $usuario]);
    }

    public function destroy($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado');
        }
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
    public function validarContraseña(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
    
        if (Hash::check($request->password, Auth::user()->password)) {
            \Log::info('Número de tarjeta: ' . Auth::user()->tarjeta);
            return response()->json([
                'success' => true,
                'numeroTarjeta' => Auth::user()->tarjeta,
            ]);
        }
    
        return response()->json(['success' => false], 401);
    }
}

