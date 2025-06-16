<%@ Page Title="Vender mi coche" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="venta.aspx.cs" Inherits="WebApplication.venta" %>

<asp:Content ID="MainContent" ContentPlaceHolderID="MainContent" runat="server">
    <style>
       
        .btn-custom {
            border-style: none;
            border-color: inherit;
            border-width: medium;
            background-color: #ff0000; 
            color: white; 
            padding: 15px 32px; 
            text-align: center; 
            text-decoration: none; 
            display: inline-block;
            font-size: 16px; 
            margin: 4px 2px;
            cursor: pointer; 
            border-radius: 5px;
            font-weight: 700;
        }
         
      
        .header-banner {
            background: url('logimg/f.jpg') no-repeat center center scroll;
            background-size: cover;
            height: 500px; 
            display: flex;
            align-items: center;
            justify-content: center;
            color: white; 
            text-align: center; 
        }
    .nuevoEstilo1 {
        font-family: "Arial Black";
    }
    .nuevoEstilo2 {
        font-family: "Arial Black";
    }
    </style>

    <div class="header-banner">
        <div>
            <h1><span class="nuevoEstilo1">Vender mi coche</span></h1>
            <p><span class="nuevoEstilo2">Te ayudamos a vender tu coche </span></p>
            <asp:Button ID="btnPublish" runat="server" Text="Publicar mi anuncio " CssClass="btn-custom" OnClick="btnPublish_Click" />
            
        </div>
    </div>
</asp:Content>
