<h1>Listado de Películas</h1>

<ul>
    @foreach($peliculas as $pelicula)
        <li>{{ $pelicula->nombre }}</li>
    @endforeach
</ul>