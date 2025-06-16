<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SpainCinema</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="margin-bottom: 1rem;">SpainCinema 🎬</h1>
        <hr>
    </header>


    <main>
    <audio id="bg-audio" autoplay loop>
    <source src="{{ asset('storage/audio/soundtrack.mp3') }}" type="audio/mpeg">
    Tu navegador no soporta audio HTML5.
    </audio>
        @yield('content')
    </main>
</body>
<script>
    document.addEventListener('click', function () {
        const audio = document.getElementById('bg-audio');
        if (audio && audio.paused) {
            audio.play().catch(err => {
                console.warn('Autoplay bloqueado:', err);
            });
        }
    }, { once: true });
</script>
</html>
