<%@ Page Title="Contacto" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="contacto.aspx.cs" Inherits="WebApplication.contacto" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto');
        font-family: 'Roboto', sans-serif;

        body {
            background: #D9B280;
            font-family: "Roboto", sans-serif;
        }

        .container {
            background: #FFFFFF;
            margin: 5% auto;
            padding: 2%;
            display: flex;
            flex-wrap: wrap;
        }

        .container .map {
            flex: 1;
            min-width: 300px;
        }

        .container .contact-form {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .container .contact-form .title {
            font-size: 2.5em;
            font-family: "Roboto", sans-serif;
            font-weight: 700;
            color: #0056b3; /* Azul */
            margin: 5% 8%;
        }

        .container .contact-form .subtitle {
            font-size: 1.2em;
            font-weight: 400;
            color: #0056b3; /* Azul */
            margin: 0 4% 5% 8%;
        }

        .container .contact-form input,
        .container .contact-form textarea {
            width: 330px;
            padding: 3%;
            margin: 2% 8%;
            color: #242424;
            border: 1px solid #B7B7B7;
        }

        .container .contact-form input::placeholder,
        .container .contact-form textarea::placeholder {
            color: #242424;
        }

        .container .contact-form .btn-send {
            background: #0056b3; /* Azul */
            width: 180px;
            height: 60px;
            color: #FFFFFF;
            font-weight: 700;
            margin: 2% 8%;  
            border: none;
            cursor: pointer;
        }

        .container .contact-info {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 2%;
        }

        .contact-info .info-box {
            width: 30%;
            background: #F9F9F9;
            padding: 2%;
            text-align: center;
        }

        .contact-info .info-box img {
            width: 30px;
            height: 30px;
            margin-bottom: 10px;
            filter: brightness(0) saturate(100%) invert(19%) sepia(82%) saturate(3022%) hue-rotate(201deg) brightness(95%) contrast(107%); /* Azul */
        }

        .contact-info .info-box h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #242424;
        }

        .contact-info .info-box p {
            font-size: 1em;
            color: #242424;
        }
    </style>
</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="MainContent" runat="server">
    <div class="container">
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3105.0791642771266!2d-0.5112375!3d38.3868132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6236ba2a07b50f%3A0x161c6e192605005b!2sEdificio%2016%20-%20Escuela%20Politecnica%20Superior%201%2C%2003690%20San%20Vicente%20del%20Raspeig%2C%20Alicante!5e0!3m2!1ses!2ses!4v1621321137058!5m2!1ses!2ses"  width="100%" height="650px" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <div class="contact-form">
            <h1 class="title">Contáctanos</h1>
            <h2 class="subtitle">Estamos aquí para ayudarte.</h2>
            <div>
                <label>&nbsp;&nbsp; De:</label>
                <asp:TextBox ID="txtFrom" runat="server"></asp:TextBox><br />
                <label>&nbsp;&nbsp; Para:</label>
                <asp:TextBox ID="txtTo" runat="server"></asp:TextBox><br />
                <label>&nbsp;&nbsp; Asunto:</label>
                <asp:TextBox ID="txtSubject" runat="server"></asp:TextBox><br />
                <label>&nbsp;&nbsp; Mensaje:</label>
                <asp:TextBox ID="txtMessage" runat="server" TextMode="MultiLine"></asp:TextBox><br />
                <label>&nbsp;&nbsp; Adjuntar Archivo:</label>
                <asp:FileUpload ID="fileAttachment" runat="server" /><br />
                <asp:Button ID="btnSend" runat="server" Text="Enviar" OnClick="btnSend_Click" CssClass="btn-send" />
            </div>
        </div>
        <div class="contact-info">
            <div class="info-box">
                <img src="https://img.icons8.com/ios-filled/50/000000/email.png" alt="Email Icon" />
                <h3>Email</h3>
                <p>onlycars162@gmail.com</p>
            </div>
            <div class="info-box">
                <img src="https://img.icons8.com/ios-filled/50/000000/phone.png" alt="Phone Icon" />
                <h3>Phone</h3>
                <p>Tel. 96 590 3400 - Fax 96 590 3464</p>
            </div>
            <div class="info-box">
                <img src="https://img.icons8.com/ios-filled/50/000000/marker.png" alt="Location Icon" />
                <h3>Office location</h3>
                <p>Escuela Politécnica Superior de la Universidad de Alicante, Carr. de San Vicente del Raspeig, s/n, 03690 San Vicente del Raspeig, Alicante</p>
            </div>
        </div>
    </div>   
</asp:Content>
