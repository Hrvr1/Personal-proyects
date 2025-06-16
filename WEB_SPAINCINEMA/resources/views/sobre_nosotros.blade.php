@extends('layouts.master')

@section('title', 'Sobre Nosotros')

@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <main class="privacy-container">
        <section class="privacy-section">
            <h2>1. Introducción</h2>
            <p>
                Bienvenidos a Spain Cinema, donde la magia del cine cobra vida. Nuestro objetivo es ofrecer una experiencia cinematográfica inolvidable, combinando tecnología de vanguardia con un servicio excepcional. A través de nuestra plataforma, podrás gestionar tus entradas, explorar la cartelera y disfrutar de tus películas favoritas con total comodidad.
            </p>
        </section>

        <section class="privacy-section">
            <h2>2. Objetivos</h2>
            <p>
                En Spain Cinema, buscamos revolucionar la forma en que disfrutas del cine. Nuestro objetivo es centralizar la gestión de funciones y salas, optimizar la experiencia de compra de entradas, y proporcionar una plataforma intuitiva para que nuestros clientes puedan explorar la cartelera y adquirir entradas de manera rápida y sencilla.
            </p>
        </section>

        <section class="privacy-section">
            <h2>3. Descripción</h2>
            <h3>3.1 Aplicación de Gestión (Intranet)</h3>
            <p>
                Nuestra aplicación interna está diseñada para el equipo de Spain Cinema, permitiendo gestionar películas, horarios y salas de manera eficiente. Con esta herramienta, los gerentes pueden programar funciones, ajustar precios y garantizar que cada proyección sea una experiencia perfecta para nuestros espectadores.
            </p>
            <h3>3.2 Consulta de Cartelera y Venta de Entradas (Web Pública)</h3>
            <p>
                La plataforma web pública está pensada para nuestros cinéfilos. Aquí podrás consultar la cartelera actualizada, explorar detalles de las películas, seleccionar tus asientos favoritos y comprar entradas de forma anticipada. Además, podrás gestionar tu perfil, añadir métodos de pago y disfrutar de promociones exclusivas.
            </p>
        </section>

        <section class="privacy-section">
            <h2>4. Público Objetivo</h2>
            <p>
                Spain Cinema está diseñado para todos los amantes del cine. Desde familias que buscan una tarde de diversión, hasta parejas en busca de una cita especial, grupos de amigos o cinéfilos apasionados. También atendemos a nuestro equipo interno, brindándoles herramientas para garantizar que cada función sea un éxito.
            </p>
        </section>

        <section class="privacy-section">
            <h2>5. Contacto</h2>
            <p>
                ¿Tienes alguna pregunta o necesitas más información? Estamos aquí para ayudarte. Contáctanos a través de los siguientes medios:
            </p>
            <ul style="list-style-type: none; padding: 0;">
                <li><strong>Email:</strong> contacto@spaincinema.com</li>
                <li><strong>Teléfono:</strong> +34 987 654 321</li>
                <li><strong>Dirección:</strong> Avenida del Cine, 123, Madrid, España</li>
            </ul>
        </section>
    </main>
@endsection