<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SpainCinema')</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @yield('styles')
    <link rel="icon" href="{{ asset('storage/imagenes/spain_cinema_logo_circular.jpg') }}" type="image/png">
</head>

<body>
    <header class="bg-white shadow-sm fixed-top">
        <div class="container d-flex align-items-center justify-content-between py-2">
            <a href="{{ route('index') }}" class="align-items-center text-decoration-none">
                <img src="{{ asset('storage/imagenes/spain_cinema_logo_circular.jpg') }}" alt="Logo SpainCinema"
                    class="logo-img me-2">
                <span class="logo">SpainCinema</span>
            </a>
            <button class="menu-toggle btn btn-outline-secondary">
                <i class="fas fa-bars"></i>
            </button>
            <div class="menu">
                <select name="cine_id" id="cine-selector" class="form-select cine-selector me-3">
                    <option value="" selected>— Selecciona un cine —</option>
                    @if (isset($cines) && $cines->isNotEmpty())
                        @foreach ($cines as $cine)
                            @if ($cine->cantidad_salas > 0)
                                <option value="{{ $cine->id }}">
                                    {{ $cine->localidad ? $cine->localidad : '' }}
                                </option>
                            @endif
                        @endforeach
                    @else
                        <option value="" disabled>No hay cines disponibles</option>
                    @endif
                </select>
                <ul class="nav d-flex align-items-center">
                    <li class="nav-item"><a href="{{ route('index') }}" class="nav-link">Inicio</a></li>
                    <li class="nav-item"><a href="{{ route('index') }}#contact-section" class="nav-link">Contacto</a>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link">Cartelera</a></li>
                    <li class="nav-item"><a href="{{ route('sobre_nosotros') }}" class="nav-link">Sobre nosotros</a>
                    </li>
                    @guest
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="{{ route('registro') }}" class="nav-link">Sign Up</a></li>
                    @else
                        <li class="nav-item"><a href="{{ route('perfil') }}" class="nav-link">Perfil</a></li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link"
                                onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('notificaciones.index') }}">
                                <i class="fas fa-envelope"></i>
                                @if (isset($notificacionesNoLeidas) && $notificacionesNoLeidas > 0)
                                    <span class="badge notificacion-danger">{{ $notificacionesNoLeidas }}</span>
                                @endif
                            </a>
                        </li>
                        @if (auth()->user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Administración
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                    <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Gestión de Usuarios</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('cines.index') }}">Gestión de Cines</a></li>
                                    <li><a class="dropdown-item" href="{{ route('salas.index') }}">Gestión de Salas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('peliculas.gestionar') }}">Gestión de
                                            Películas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.sesiones.crear') }}">Gestión de
                                            Sesiones</a></li>
                                </ul>
                            </li>
                        @endif
                    @endauth
                    <li> <button id="music-toggle" class="music-navbar-button" aria-label="Controlar música">
                        <i id="music-icon" class="fas fa-volume-up"></i>
                    </button></li>
                </ul>
            </div>
        </div>
    </header>

    <main class="content container mt-5 pt-5" style="margin-top: 100px;">
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
        <div class="errores">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0" style="list-style: none; padding-left: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        @yield('content')
    </main>
    <div class="info-links">
        <ul>
            <li><a href="{{ url('/politica') }}">Política y Privacidad</a></li>
        </ul>
    </div>
    <footer class="bg-white text-center py-3 mt-5">
        <p>&copy; 2025 SpainCinema. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cineSelector = document.getElementById("cine-selector");
            const savedCineId = localStorage.getItem("selectedCineId");
            if (savedCineId) {
                cineSelector.value = savedCineId;
            }
            cineSelector.addEventListener("change", function () {
                const selectedCineId = this.value;
                if (!selectedCineId) {
                    localStorage.removeItem("selectedCineId");
                } else {
                    localStorage.setItem("selectedCineId", selectedCineId);
                }
                if (window.location.pathname.includes("/cartelera") && selectedCineId) {
                    window.location.href = `/cartelera/${selectedCineId}`;
                }
                if (window.location.pathname.includes("/estrenos")) {
                    window.location.href = `/estrenos/${selectedCineId}`;
                }
            });

            document.querySelector('a[href="#"]').addEventListener("click", function (event) {
                event.preventDefault();

                const selectedCineId = localStorage.getItem("selectedCineId");
                if (selectedCineId) {
                    window.location.href = `/cartelera/${selectedCineId}`;
                } else {
                    alert("Por favor, selecciona un cine antes de ver la cartelera.");
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.querySelector(".menu-toggle");
            const menu = document.querySelector(".menu");

            menuToggle.addEventListener("click", function () {
                menu.classList.toggle("show-menu");
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const links = document.querySelectorAll('.estreno-link');

            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    const cineId = localStorage.getItem("selectedCineId");

                    if (cineId) {
                        window.location.href = `/estrenos/${cineId}`;
                    } else {
                        alert("Por favor, selecciona un cine antes de ver los estrenos.");
                    }
                });
            });
        });
    </script>

    <audio id="background-music" loop>
        <source src="{{ asset('storage/audio/soundtrack.mp3') }}" type="audio/mpeg">
    </audio>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const audio = document.getElementById('background-music');
    const toggleBtn = document.getElementById('music-toggle');
    const icon = document.getElementById('music-icon');

    const savedTime = parseFloat(localStorage.getItem('music-time')) || 0;
    const musicEnabled = localStorage.getItem('music-enabled') !== 'false';

    audio.volume = 0.5;

    function playIfAllowed() {
        if (musicEnabled) {
            audio.play().then(() => {
                icon && (icon.className = 'fas fa-volume-up');
            }).catch(err => {
                // Bloqueado por el navegador (no interacción del usuario)
                console.log('Autoplay bloqueado por el navegador', err);
            });
        } else {
            icon && (icon.className = 'fas fa-volume-mute');
        }
    }

    // Establecer tiempo cuando se conoce duración
    audio.addEventListener('loadedmetadata', () => {
        if (savedTime && savedTime < audio.duration) {
            audio.currentTime = savedTime;
        }
        playIfAllowed();
    });

    // Guardar tiempo cada segundo
    setInterval(() => {
        if (!audio.paused) {
            localStorage.setItem('music-time', audio.currentTime);
        }
    }, 1000);

    // Botón de toggle manual
    toggleBtn?.addEventListener('click', () => {
        if (audio.paused) {
            audio.play();
            icon.className = 'fas fa-volume-up';
            localStorage.setItem('music-enabled', 'true');
        } else {
            audio.pause();
            icon.className = 'fas fa-volume-mute';
            localStorage.setItem('music-enabled', 'false');
        }
    });

    // Guardar tiempo justo antes de salir
    window.addEventListener('beforeunload', () => {
        if (!audio.paused) {
            localStorage.setItem('music-time', audio.currentTime);
        }
    });
});
</script>

<script src="https://www.youtube.com/iframe_api"></script>

<script>
    let trailerPlayer;
    let backgroundAudio;

    function onYouTubeIframeAPIReady() {
        const iframe = document.getElementById('trailer-video');
        if (!iframe) return;

        trailerPlayer = new YT.Player('trailer-video', {
            events: {
                'onStateChange': onTrailerStateChange
            }
        });
    }

    function onTrailerStateChange(event) {
        backgroundAudio = backgroundAudio || document.getElementById('background-music');
        const musicEnabled = localStorage.getItem('music-enabled') !== 'false';

        // 1 = playing, 2 = paused, 0 = ended
        if (event.data === 1 && !backgroundAudio.paused) {
            backgroundAudio.pause();
        } else if ((event.data === 0 || event.data === 2) && musicEnabled) {
            backgroundAudio.play().catch(() => {});
        }
    }
</script>




</body>

</html>