<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Cines;
use App\Models\Peliculas;
use App\Models\Notificacion;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Verificar si la tabla 'cines' existe antes de acceder a ella
        if (Schema::hasTable('cines')) {
            View::share('cines', cache()->remember('cines', 60*60, fn() => Cines::all()));
        } else {
            View::share('cines', collect());
        }

        // Verificar si la tabla 'peliculas' existe antes de acceder a ella
        if (Schema::hasTable('peliculas')) {
            $generos = cache()->remember('generos', 60*60, fn() => Peliculas::select('genero')->distinct()->pluck('genero'));
            View::share('generos', $generos);
        } else {
            View::share('generos', collect());
        }

        View::composer('*', function ($view) {
            if (auth()->check()) {
                $notificacionesNoLeidas = Notificacion::where('correo', auth()->user()->email)
                    ->where('leida', false)
                    ->count();
                $view->with('notificacionesNoLeidas', $notificacionesNoLeidas);
            }
        });
    }
}
