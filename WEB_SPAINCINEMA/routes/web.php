<?php

use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CinesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\CarteleraController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AsientosController;
use App\Http\Controllers\MetodoPagoController;



// Públicas
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/politica', fn() => view('politica'))->name('politica');
Route::get('/sobre-nosotros', fn() => view('sobre_nosotros'))->name('sobre_nosotros');
Route::get('/cartelera/{cine_id}', [CarteleraController::class, 'cartelera'])->name('cartelera');
Route::get('/estrenos/{cine_id}', [CarteleraController::class, 'estrenos'])->name('estrenos');


// Contacto
Route::get('/contacto', fn() => redirect()->route('index')->with('scrollToContact', true))->name('index.contacto');
Route::post('/contacto', [NotificacionController::class, 'enviar'])->name('contacto.enviar');

// Registro y login
# Auth::routes();

Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.post');
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');
Route::get('/registro', fn() => view('registro_usuario'))->name('register');
Route::post('/registro', [UsuarioController::class, 'registrar'])->name('registro');


// Auth
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [UsuarioController::class, 'ver_perfil'])->name('perfil');
    Route::get('/editar_perfil', fn() => view('editar_perfil', ['user' => Auth::user()]))->name('perfil.editar');
    Route::put('/editar_perfil', [UsuarioController::class, 'editar_perfil'])->name('perfil.editar.put');
    Route::delete('/borrar_perfil', [UsuarioController::class, 'borrar_perfil'])->name('perfil.borrar');

    Route::get('/tickets', [TicketsController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{id}', [TicketsController::class, 'mostrar_info'])->name('tickets.info');
    Route::delete('/tickets/{id}', [TicketsController::class, 'borrar'])->name('tickets.delete');
    Route::get('/reservas', [TicketsController::class, 'ver_reservas'])->name('tickets.reservados');
    Route::get('/reservas/confirmar/{id}', [TicketsController::class, 'confirmarReserva'])->name('tickets.confirmar_reserva');
    Route::post('/tickets/generar', [TicketsController::class, 'generar_ticket'])->name('tickets.generar');

    // Cambiado: nombres únicos para pago/editar
    Route::get('/pago/editar', fn() => view('editar_metodos_pago', ['user' => Auth::user()]))->name('pago.editar.view');
    Route::put('/pago/editar', [UsuarioController::class, 'editar_metodos_pago'])->name('pago.editar.put');
    Route::get('/pago/editar/metodos', [UsuarioController::class, 'mostrar_metodos_pago'])->name('pago.editar.metodos');

    Route::post('/validar-contraseña', [UsuarioController::class, 'validarContraseña'])->name('validar.contraseña');
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::delete('/notificaciones/{id}', [NotificacionController::class, 'destroy'])->name('notificaciones.destroy');
    Route::get('/notificaciones/{id}', [NotificacionController::class, 'show'])->name('notificaciones.show');
    Route::post('/notificaciones/{id}/responder', [NotificacionController::class, 'responder'])->name('notificaciones.responder');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Selección de Asientos
    Route::get('/asientos/{sala_id}', [App\Http\Controllers\AsientosController::class, 'show'])->name('asientos.show');
    Route::post('/asientos/reservar', [AsientosController::class, 'reservar'])->name('asientos.reservar');
    Route::get('/metodo-pago', [MetodoPagoController::class, 'index'])->name('metodo.pago');
    Route::post('/procesar-pago', [MetodoPagoController::class, 'procesar'])->name('pago.procesar');
});

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/registrar', fn() => view('registro_usuario', ['isAdmin' => true]))->name('admin.create');
    Route::post('/registrar', [AdminController::class, 'create'])->name('admin.registrarAdmin');
    Route::post('/asignar/{id}', [AdminController::class, 'asignarAdmin'])->name('admin.asignarAdmin');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    Route::get('/peliculas/asociar/{pelicula?}', [AdminController::class, 'asociarPeliculas'])->name('admin.peliculas.asociar');
    Route::post('/peliculas/asociar', [AdminController::class, 'guardarAsociacion'])->name('admin.peliculas.asociar.guardar');
    Route::get('/sesiones/crear', [AdminController::class, 'crearSesion'])->name('admin.sesiones.crear');
    Route::post('/sesiones/guardar', [AdminController::class, 'guardarSesion'])->name('admin.sesiones.guardar');

    // Rutas de Cines
    Route::prefix('cines')->group(function () {
        Route::get('/', [CinesController::class, 'index'])->name('cines.index');
        Route::get('/create', [CinesController::class, 'create'])->name('cines.create');
        Route::get('/{id}', [CinesController::class, 'show'])->name('cines.show');
        Route::post('/', [CinesController::class, 'store'])->name('cines.store');
        Route::put('/{id}', [CinesController::class, 'update'])->name('cines.update');
        Route::get('/{id}/edit', [CinesController::class, 'edit'])->name('cines.edit');
        Route::delete('/{id}', [CinesController::class, 'destroy'])->name('cines.destroy');
        Route::get('/{id}/peliculas', [CinesController::class, 'peliculas'])->name('cines.peliculas');
        Route::post('/desasociar-pelicula', [AdminController::class, 'desasociarPelicula'])->name('cines.desasociarPelicula');
    });

    // Rutas de Películas
    Route::prefix('peliculas')->group(function () {
        Route::get('/', [PeliculasController::class, 'index'])->name('peliculas.index');
        Route::get('/create', [PeliculasController::class, 'create'])->name('peliculas.create');
        Route::post('/', [PeliculasController::class, 'store'])->name('peliculas.store.admin');
        Route::get('/{id}/edit', [PeliculasController::class, 'edit'])->name('peliculas.edit');
        Route::put('/{id}', [PeliculasController::class, 'update'])->name('peliculas.update');
        Route::delete('/{id}', [PeliculasController::class, 'destroy'])->name('peliculas.destroy');
        Route::get('/gestionar', [PeliculasController::class, 'gestionar'])->name('peliculas.gestionar');
        Route::get('/{id}', [PeliculasController::class, 'show'])->name('peliculas.show.admin');
    });

    // Rutas de Salas
    Route::prefix('salas')->group(function () {
        Route::get('/', [SalasController::class, 'index'])->name('salas.index');
        Route::get('/create', [SalasController::class, 'create'])->name('salas.create');
        Route::get('/{id}', [SalasController::class, 'show'])->name('salas.show');
        Route::post('/', [SalasController::class, 'store'])->name('salas.store');
        Route::put('/{id}', [SalasController::class, 'update'])->name('salas.update');
        Route::get('/{id}/edit', [SalasController::class, 'edit'])->name('salas.edit');
        Route::delete('/{id}', [SalasController::class, 'destroy'])->name('salas.destroy');
        Route::get('/{id}/peliculas', [SalasController::class, 'peliculas'])->name('salas.peliculas');
        Route::post('/desasociar-pelicula', [AdminController::class, 'desasociarPelicula'])->name('salas.desasociarPelicula');
    });

    Route::get('/audio', fn() => view('audio'))->name('audio');

    Route::resource('usuarios', UsuarioController::class);
});

// Rutas de Películas
Route::prefix('peliculas')->group(function () {
    Route::post('/', [PeliculasController::class, 'store'])->name('peliculas.store.public');
    Route::get('/{id}/{cine_id}', [PeliculasController::class, 'show'])->name('peliculas.show.public');
});

//Cartelera
Route::get('/cartelera/{id}', [CarteleraController::class, 'show'])->name('cartelera.show');


Route::get('/forgot-password', function () {
    return view('auth.passwords.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors([
            'email' => $status === Password::INVALID_USER
                ? 'No existe ningún usuario registrado con ese correo.'
                : __($status)
        ]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');