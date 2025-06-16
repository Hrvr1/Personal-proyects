<%@ Page Title="OnlyCars" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Default.aspx.cs" Inherits="WebApplication.Default" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
    <style>
        .background {
            background-image: url('APP_Images/default/2024-G-SUV-HERO-DR.jpg');
            background-size: cover;
            background-position: center;
        }

        .translucent-box {
            background-color: rgba(173, 216, 230, 0.8); /* Ajuste de opacidad */
            padding: 20px; /* Espaciado interno */
            border-radius: 15px; /* Bordes redondeados */
            max-width: 600px; /* Ancho máximo del recuadro */
            text-align: center; /* Centrar contenido */
            color: #333; /* Color de texto más oscuro */
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .social-buttons a {
            margin: 0 10px;
        }

        .social-buttons img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .map-container {
            margin: 20px auto;
            width: 100%;
            max-width: 400px;
            height: 300px;
            border: 2px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
        }

        .btn-custom {
            display: inline-block;
            width: 200px;
            padding: 10px 20px;
            margin: 20px auto;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.3);
            transition: all 0.75s ease-in-out;
            border-radius: 50%;
            z-index: -1;
            transform: translate(-50%, -50%) scale(0);
        }

        .btn-custom:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .btn-custom:hover {
            background-color: #0056b3;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .btn-custom.btn-catalogo {
            background-color: #1e90ff;
        }

        .btn-custom.btn-contacto {
            background-color: #007bff;
        }
    </style>
</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="MainContent" runat="server">
    <div class="background" style="display: flex; justify-content: center; align-items: center; min-height: calc(100vh - 56px - 100px);">
        <div class="translucent-box">
            <h1>Bienvenido a OnlyCars</h1>
            <p>Somos una plataforma líder en el mercado de compra y venta de coches.</p>
            <p>Ofrecemos una amplia selección de vehículos de alta calidad a precios competitivos.</p>
            <p>Con nuestra interfaz fácil de usar, encontrar el coche perfecto nunca ha sido tan sencillo.</p>
            <p>Regístrate hoy mismo y descubre la mejor manera de comprar y vender coches.</p>
            <p>Déjanos ayudarte a recorrer el mundo de una manera segura y reconfortante.</p>
            <a href="Catalogo.aspx" class="btn-custom btn-catalogo">Ver Catálogo</a>
            
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3105.0791642771266!2d-0.5112375!3d38.3868132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6236ba2a07b50f%3A0x161c6e192605005b!2sEdificio%2016%20-%20Escuela%20Politecnica%20Superior%201%2C%2003690%20San%20Vicente%20del%20Raspeig%2C%20Alicante!5e0!3m2!1ses!2ses!4v1621321137058!5m2!1ses!2ses" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>

            <div class="social-buttons">
                <a href="https://www.instagram.com/onlycars__ua/" target="_blank">
                    <img src="App_Images/default/logo_insta.jpg" alt="Instagram" />
                </a>
                <a href="https://x.com/OnlyCars_UA" target="_blank">
                    <img src="App_Images/default/logo_X.jpg" alt="Twitter" />
                </a>
                <a href="https://github.com/jcz13-ua/hada-proyecto-grupo" target="_blank">
                    <img src="App_Images/default/logo_gitHub.jpg" alt="GitHub" />
                </a>
            </div>  

            <a href="contacto.aspx" class="btn-custom btn-contacto">Contactenos</a>
        </div>
    </div>
</asp:Content>
