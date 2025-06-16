@extends('layouts.master')

@section('title', 'Detalles de la Película')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/show_pelicula.css') }}">

    <div class="container my-5">
        <div class="pelicula-container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="pelicula-imagen justify-content-center">
                        <img src="{{ asset('storage/imagenes/' . $pelicula->imagen) }}" alt="{{ $pelicula->nombre }}"
                            class="img-fluid">
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="pelicula-info">
                        <h1 class="text-center text-md-center"
                            style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                            {{ $pelicula->nombre }}
                            @if($pelicula->reviews->count())
                                <span
                                    style="font-size: 1rem; color: #111; background: #ffe066; border-radius: 8px; padding: 2px 8px; display: inline-block;">
                                    {{ number_format($pelicula->reviews->avg('puntuacion'), 1) }} ★
                                </span>
                            @endif
                        </h1>
                        <div
                            class="pelicula-generos d-flex justify-content-center justify-content-md-center flex-wrap gap-2 my-3">
                            @foreach(explode(',', $pelicula->genero) as $tag)
                                <span class="pelicula-genero">{{ trim($tag) }}</span>
                            @endforeach
                        </div>

                        <h2 class="pelicula-precio">Precio por ticket: €<span
                                id="precio-unitario">{{ number_format($pelicula->precio ?? 7.50, 2) }}</span></h2>
                        <h2 class="pelicula-precio-total">Total: €<span
                                id="precio-total">{{ number_format($pelicula->precio ?? 7.50, 2) }}</span></h2>

                        <p class="pelicula-descripcion">{{ $pelicula->descripcion }}</p>

                        <form id="pelicula-form" action="" method="GET" class="pelicula-form">
                            @csrf
                            <input type="hidden" name="pelicula_id" value="{{ $pelicula->id }}">
                            <input type="hidden" name="precio" value="{{ $precio }}">
                            <input type="hidden" name="cine_id" value="{{ $cine->id }}">
                            <input type="hidden" id="sala_id" name="sala_id" value="{{ $sala->id }}">

                            <div class="mb-3">
                                <label for="funcion_id" class="form-label">Sesión</label>
                                <select name="funcion_id" id="funcion_id" class="form-select" required>
                                    @foreach ($pelicula->salas as $sala)
                                        @if ($sala->cine_id == request('cine_id'))
                                            <option value="{{ $sala->id }}|{{ $sala->pivot->fecha_hora }}">
                                                Sala {{ $sala->numero }} -
                                                {{ \Carbon\Carbon::parse($sala->pivot->fecha_hora)->format('d/m/Y H:i') }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad de Tickets:</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="1" min="1"
                                    max="10" required>
                                @error('cantidad')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <button type="button" id="continuar-btn" class="btn btn-success w-100">Continuar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="trailer-container mt-5">
            @if ($pelicula->trailer)
                <iframe id="trailer-video"
                    src="{{ str_replace('watch?v=', 'embed/', $pelicula->trailer) }}?enablejsapi=1"
                    frameborder="0"
                    allow="autoplay; encrypted-media"
                    allowfullscreen
                    class="w-100">
                </iframe>
            @else
                <p class="no-trailer text-center">No hay tráiler disponible para esta película.</p>
            @endif
        </div>

        <div class="reseñas-container mt-5">
            <h2>Reseñas</h2>
            @php
                $media = $pelicula->reviews->count() ? number_format($pelicula->reviews->avg('puntuacion'), 2) : 'N/A';
            @endphp
            <p class="mb-3">
                <span style="font-size: 1.2em;">
                    @if($media !== 'N/A')
                        <span style="color: #222;">{{ number_format($pelicula->reviews->avg('puntuacion'), 1) }} / 5.0</span>
                        <span style="color: #ffc107; font-size:1.3em;">&#9733;</span>
                    @endif
                </span>
            </p>
            <div class="mb-3 d-flex justify-content-center gap-3">
                <select id="filtro-puntuacion" class="form-select" style="max-width:200px;">
                    <option value="todas">Cualquiera</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} estrellas</option>
                    @endfor
                </select>
                <select id="filtro-fecha" class="form-select" style="max-width:200px;">
                    <option value="todas">Todas</option>
                    <option value="semana">Esta semana</option>
                    <option value="mes">Este mes</option>
                    <option value="anio">Este año</option>
                </select>
            </div>

            @auth
                <form action="{{ route('reviews.store') }}" method="POST" class="reseña-form">
                    @csrf
                    <input type="hidden" name="pelicula_id" value="{{ $pelicula->id }}">

                    <div class="mb-3">
                        <label for="puntuacion" class="form-label">Puntuación:</label>
                        <div class="star-rating" style="direction: rtl; font-size: 2rem;">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="puntuacion" value="{{ $i }}" style="display:none;"
                                    required>
                                <label for="star{{ $i }}" style="cursor:pointer; color: #ccc;" onmouseover="marcar({{ $i }})"
                                    onmouseout="borrar()" onclick="seleccionar({{ $i }})">&#9733;</label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="comentario" class="form-label">Comentario:</label>
                        <textarea name="comentario" rows="3" class="form-control"
                            placeholder="¿Qué te ha parecido la película?"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar reseña</button>
                </form>
            @else
                <p>Inicia sesión para dejar una reseña.</p>
            @endauth
            <div id="lista-reseñas">
                @forelse($pelicula->reviews as $review)
                    <div class="reseña border-top pt-3 text-start" data-puntuacion="{{ $review->puntuacion }}">
                        <div class="reseña-vista">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <strong>{{ $review->user->nombre }}</strong>
                                    <span class="estrellas ms-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                style="color: {{ $i <= $review->puntuacion ? '#ffc107' : '#ccc' }}; font-size: 1.5rem;">&#9733;</span>
                                        @endfor
                                    </span>
                                </div>
                                <span class="text-muted" style="font-size: 0.95em;">
                                    {{ $review->created_at->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <p>{{ $review->comentario }}</p>
                            @auth
                                @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                                    <div class="mb-2">
                                        <button type="button" class="btn btn-sm btn-warning editar-btn"
                                            data-review-id="{{ $review->id }}">Editar</button>
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('¿Seguro que quieres borrar esta reseña?')">Borrar</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                        @auth
                            @if(auth()->id() === $review->user_id)
                                <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="editar-form"
                                    id="editar-form-{{ $review->id }}" style="display:none;">
                                    @csrf
                                    @method('PUT')
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <strong>{{ $review->user->nombre }}</strong>
                                            <span class="estrellas ms-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <label
                                                        style="margin:0;cursor:pointer;font-size:1.5rem;color:{{ $i <= $review->puntuacion ? '#ffc107' : '#ccc' }};">
                                                        <input type="radio" name="puntuacion" value="{{ $i }}" style="display:none;"
                                                            @if($review->puntuacion == $i) checked @endif>
                                                        &#9733;
                                                    </label>
                                                @endfor
                                            </span>
                                        </div>
                                        <span class="text-muted" style="font-size: 0.95em;">
                                            {{ $review->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="comentario" class="form-control form-control-sm" rows="2"
                                            required>{{ $review->comentario }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                                    <button type="button" class="btn btn-sm btn-secondary cancelar-edicion"
                                        data-review-id="{{ $review->id }}">Cancelar</button>
                                </form>
                            @endif
                        @endauth
                    </div>

                @empty
                    <p>Aún no hay reseñas para esta película.</p>
                @endforelse
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isAuthenticated = "{{ auth()->check() ? 'true' : 'false' }}";

                const continuarBtn = document.getElementById('continuar-btn');
                const funcionSelect = document.getElementById('funcion_id');
                const cantidadInput = document.getElementById('cantidad');
                const form = document.getElementById('pelicula-form');

                continuarBtn.addEventListener('click', function (event) {
                    event.preventDefault();

                    if (isAuthenticated === 'false') {
                        alert('Debes iniciar sesión para continuar.');
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    const seleccion = funcionSelect.value.split('|');
                    const salaId = seleccion[0];
                    const fechaHora = seleccion[1];
                    if (!salaId || salaId === "undefined") {
                        alert('Por favor, selecciona una sesión válida.');
                        return;
                    }
                    const url = `{{ route('asientos.show', ':sala_id') }}`.replace(':sala_id', salaId);
                    const queryParams = new URLSearchParams({
                        funcion_id: `${salaId}|${fechaHora}`,
                        cantidad: cantidadInput.value,
                    });
                    window.location.href = `${url}?${queryParams.toString()}`;
                });
            });

            function marcar(star) {
                for (let i = 1; i <= 5; i++) {
                    document.querySelector('label[for="star' + i + '"]').style.color = i <= star ? '#ffc107' : '#ccc';
                }
            }
            function borrar() {
                let checked = document.querySelector('input[name="puntuacion"]:checked');
                let value = checked ? checked.value : 0;
                for (let i = 1; i <= 5; i++) {
                    document.querySelector('label[for="star' + i + '"]').style.color = i <= value ? '#ffc107' : '#ccc';
                }
            }
            function seleccionar(star) {
                for (let i = 1; i <= 5; i++) {
                    document.querySelector('label[for="star' + i + '"]').style.color = i <= star ? '#ffc107' : '#ccc';
                }
            }
            document.addEventListener('DOMContentLoaded', borrar);
            document.addEventListener('DOMContentLoaded', function () {
                const cantidadInput = document.getElementById('cantidad');
                const precioUnitario = parseFloat(document.getElementById('precio-unitario').textContent.replace(',', '.'));
                const precioTotalSpan = document.getElementById('precio-total');

                function actualizarTotal() {
                    const cantidad = parseInt(cantidadInput.value) || 1;
                    const total = (precioUnitario * cantidad).toFixed(2);
                    precioTotalSpan.textContent = total.replace('.', ',');
                }

                cantidadInput.addEventListener('input', actualizarTotal);
                actualizarTotal();
            });
            document.addEventListener('DOMContentLoaded', function () {
                const filtroPuntuacion = document.getElementById('filtro-puntuacion');
                const filtroFecha = document.getElementById('filtro-fecha');
                const reseñas = document.querySelectorAll('#lista-reseñas .reseña');

                function filtrarReseñas() {
                    const valorPuntuacion = filtroPuntuacion.value;
                    const valorFecha = filtroFecha.value;
                    const ahora = new Date();

                    reseñas.forEach(function (reseña) {
                        let mostrar = true;
                        if (valorPuntuacion !== 'todas' && reseña.getAttribute('data-puntuacion') !== valorPuntuacion) {
                            mostrar = false;
                        }
                        if (mostrar && valorFecha !== 'todas') {
                            const fechaTexto = reseña.querySelector('.text-muted').textContent.trim();
                            const partes = fechaTexto.split(' ');
                            const [dia, mes, anio] = partes[0].split('/');
                            const fechaResena = new Date(`${anio}-${mes}-${dia}T${partes[1] || '00:00'}`);

                            if (valorFecha === 'semana') {
                                const primerDiaSemana = new Date(ahora);
                                primerDiaSemana.setDate(ahora.getDate() - ahora.getDay());
                                primerDiaSemana.setHours(0, 0, 0, 0);
                                if (fechaResena < primerDiaSemana) mostrar = false;
                            } else if (valorFecha === 'mes') {
                                if (fechaResena.getMonth() !== ahora.getMonth() || fechaResena.getFullYear() !== ahora.getFullYear()) mostrar = false;
                            } else if (valorFecha === 'anio') {
                                if (fechaResena.getFullYear() !== ahora.getFullYear()) mostrar = false;
                            }
                        }

                        reseña.style.display = mostrar ? '' : 'none';
                    });
                }

                filtroFecha.addEventListener('change', filtrarReseñas);
                filtroPuntuacion.addEventListener('change', filtrarReseñas);
                filtrarReseñas();
            });

            document.querySelectorAll('.editar-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-review-id');
                    const reseña = this.closest('.reseña');
                    reseña.querySelector('.reseña-vista').style.display = 'none';
                    reseña.querySelector('.editar-form').style.display = 'block';
                });
            });
            document.querySelectorAll('.cancelar-edicion').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-review-id');
                    const reseña = this.closest('.reseña');
                    reseña.querySelector('.editar-form').style.display = 'none';
                    reseña.querySelector('.reseña-vista').style.display = '';
                });
            });
            document.querySelectorAll('.editar-form .estrellas label').forEach(label => {
                label.addEventListener('click', function () {
                    const estrellas = this.parentNode.querySelectorAll('label');
                    const valor = this.querySelector('input').value;
                    estrellas.forEach((l, idx) => {
                        l.style.color = (idx + 1) <= valor ? '#ffc107' : '#ccc';
                    });
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

        if (event.data === YT.PlayerState.PLAYING) {
            if (!backgroundAudio.paused) backgroundAudio.pause();
        } else if (
            event.data === YT.PlayerState.PAUSED ||
            event.data === YT.PlayerState.ENDED
        ) {
            if (musicEnabled) {
                backgroundAudio.play().catch(() => {});
            }
        }
    }
</script>
@endsection