<%@ Page Title="Consejos" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Consejos.aspx.cs" Inherits="WebApplication.Consejos" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <h2>Consejos</h2>
    <asp:Button ID="btnMostrarCompras" runat="server" Text="Compras" OnClick="ButonMostrarCompras_Click" 
        CssClass="custom-button" />
    <asp:Literal ID="LiteralCompras" runat="server" Visible="false"></asp:Literal>
    <asp:Button ID="btnMostrarVentas" runat="server" Text="Ventas" OnClick="ButonMostrarVentas_Click" 
        CssClass="custom-button" />
    <asp:Literal ID="LiteralVentas" runat="server"  Visible="false"></asp:Literal>
    <asp:Button ID="btnMostrarGarantia" runat="server" Text="Garantía OnlyCars" OnClick="ButonMostrarGarantia_Click" 
        CssClass="custom-button" />
    <asp:Literal ID="LiteralGarantia" runat="server"  Visible="false"></asp:Literal>
    <asp:Button ID="btnMostrarServicio" runat="server" Text="Servicio de mantenimiento" OnClick="ButonMostrarServicio_Click" 
        CssClass="custom-button" />
    <asp:Literal ID="LiteralServicio" runat="server"  Visible="false"></asp:Literal>
</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="head" runat="server">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }

        h2 {
            color: #007BFF;
            text-align: center;
            margin-top: 20px;
        }

        .custom-button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 10px auto;
            transition: background-color 0.3s, transform 0.3s;
        }

        .custom-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .custom-button:active {
            background-color: #003d80;
        }

        .custom-button:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.5);
        }
    </style>
</asp:Content>
