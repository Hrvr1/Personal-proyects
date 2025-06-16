@extends('layouts.master')

@section('title', 'SpainCinema - Inicio')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <section class="hero-section text-white text-center d-flex align-items-center justify-content-center mt-3"
        style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('{{ asset('storage/imagenes/cinebanner.jpg') }}') center/cover no-repeat; min-height: 60vh;">
        <div class="container">
            <h1 class="display-3 fw-bold mb-3">¡Vive el cine como nunca antes!</h1>
            <p class="lead mb-4">Descubre los últimos estrenos y reserva tus entradas en segundos.</p>
            <div class="mb-4">
                <span class="me-3">En colaboración con:</span>
                <img src="{{ asset('storage/imagenes/cv.png') }}" alt="Partner 1" height="40" class="mx-2"
                    style="border-radius: 8px; padding: 2px;">
                <img src="{{ asset('storage/imagenes/movistar.png') }}" alt="Partner 2" height="40" class="mx-2"
                    style="border-radius: 8px; padding: 2px;">
            </div>
            <div class="mt-4">
                <a href="#" class="me-3 text-white"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="#" class="me-3 text-white"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="#" class="me-3 text-white"><i class="fab fa-twitter fa-2x"></i></a>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <h2 class="carousel-title text-center ">Próximos Estrenos</h2>
        <div id="estrenosCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @if ($peliculas->isEmpty())
                    <div class="carousel-item active">
                        <img src="{{ asset('storage/imagenes/estrenos.png') }}" class="d-block w-100" alt="Próximos estrenos">
                    </div>
                @else
                    @foreach ($peliculas->chunk(3) as $chunk)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row">
                                @foreach ($chunk as $pelicula)
                                    <div class="col-12 col-md-4">
                                        <a href="#" data-pelicula="{{ $pelicula->id }}" class="carousel-item-content text-center estreno-link">
                                            <div class="aspect-ratio-box">
                                                <img src="{{ asset('storage/imagenes/' . $pelicula->imagen) }}"
                                                    class="img-fluid rounded" alt="{{ $pelicula->titulo }}">
                                            </div>
                                            <p class="mt-2">{{ $pelicula->titulo }}</p>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#estrenosCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#estrenosCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
    <section class="features-section py-5 mt-5 ">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fa-solid fa-film fa-3x mb-3 text-primary"></i>
                        <h5>Últimos Estrenos</h5>
                        <p>Siempre actualizado con las películas más recientes.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fa-solid fa-ticket fa-3x mb-3 text-success"></i>
                        <h5>Compra Fácil</h5>
                        <p>Reserva tus entradas en pocos clics y sin complicaciones.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <i class="fa-solid fa-star fa-3x mb-3 text-warning"></i>
                        <h5>Experiencia Premium</h5>
                        <p>Disfruta de la mejor calidad de imagen y sonido.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials-section py-5  bg-light">
        <div class="container">
            <h2 class="text-center mb-4">¿Qué opinan nuestros usuarios?</h2>
            <div class="row justify-content-center g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-lg h-100">
                        <div class="card-body">
                            <div class="mb-3 text-center">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg"
                                    class="rounded-circle border border-3 border-primary shadow" width="60" alt="Usuario">
                            </div>
                            <blockquote class="blockquote mb-3 text-center">
                                <p class="fst-italic text-dark">
                                    “¡Me encanta la facilidad para ver los estrenos y comprar entradas!”
                                </p>
                            </blockquote>
                            <div class="text-center">
                                <span class="fw-bold text-primary">Carlos G.</span>
                                <div class="small text-muted">Cinefan</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-lg h-100">
                        <div class="card-body">
                            <div class="mb-3 text-center">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                    class="rounded-circle border border-3 border-success shadow" width="60" alt="Usuario">
                            </div>
                            <blockquote class="blockquote mb-3 text-center">
                                <p class="fst-italic text-dark">
                                    “La web es súper intuitiva y el soporte responde rápido.”
                                </p>
                            </blockquote>
                            <div class="text-center">
                                <span class="fw-bold text-success">María L.</span>
                                <div class="small text-muted">Usuaria frecuente</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="contact-section" class="contact-form mt-5">
        <h2>Contacta con nosotros</h2>
        <form action="/contacto" method="POST">
            @csrf
            <div class="mb-3">
                <label for="cine" class="form-label">Cine*</label>
                <select id="cine" name="cine" class="form-select" required>
                    <option value="">—Por favor, elige una opción—</option>
                    @foreach ($cines as $cine)
                        <option value="{{ $cine->id }}">{{ $cine->nombre }} - {{ $cine->localidad }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="consulta" class="form-label">Tipo de consulta*</label>
                <select id="consulta" name="consulta" class="form-select" required>
                    <option value="">—Por favor, elige una opción—</option>
                    <option value="General">General</option>
                    <option value="Soporte">Soporte</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre*</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico*</label>
                <input type="email" id="correo" name="correo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" class="form-control">
            </div>
            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje*</label>
                <textarea id="mensaje" name="mensaje" rows="5" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </section>
@endsection