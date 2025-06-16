<%@ Page Title="Resumen del Anuncio" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="ResumenAnuncio.aspx.cs" Inherits="WebApplication.ResumenAnuncio" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <style>
    .resumen-anuncio-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f0f0f0;
    }

    .resumen-anuncio {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        max-width: 600px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .resumen-anuncio h2 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .resumen-anuncio p {
        margin: 10px 0;
    }

    .resumen-anuncio p strong {
        color: #555;
    }

    .imagen-anuncio {
        text-align: center;
        margin-top: 20px;
    }

    .mensaje-error {
        text-align: center;
        margin-top: 20px;
        color: red;
    }
</style>
    <div class="resumen-anuncio-container">
        <div class="resumen-anuncio">
            <h2>Resumen de tu Anuncio</h2>
            <p><strong>Año:</strong> <asp:Label ID="lblAño" runat="server" /></p>
            <p><strong>Marca:</strong> <asp:Label ID="lblMarca" runat="server" /></p>
            <p><strong>Modelo:</strong> <asp:Label ID="lblModelo" runat="server" /></p>
            <p><strong>Combustible:</strong> <asp:Label ID="lblCombustible" runat="server" /></p>
            <p><strong>Transmisión:</strong> <asp:Label ID="lblTransmision" runat="server" /></p>
            <p><strong>Color:</strong> <asp:Label ID="lblColor" runat="server" /></p>
            <p><strong>Kilometraje:</strong> <asp:Label ID="lblKilometros" runat="server" /></p>
            <p><strong>Descripción Adicional:</strong> <asp:Label ID="lblDescripcionAdicional" runat="server" /></p>
            <p><strong>Precio:</strong> <asp:Label ID="lblPrecio" runat="server" /></p>
            <asp:Image ID="imgCar" runat="server" Visible="false" Height="120px" Width="203px" />
            <asp:Label ID="lblMessage" runat="server" Text="" ForeColor="Red" />
        </div>
    </div>
</asp:Content>


