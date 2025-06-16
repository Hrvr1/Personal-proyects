<%@ Page Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="NoNotificaciones.aspx.cs" Inherits="WebApplication.NoNotificaciones" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <div class="no-notifications-container">
        <h2>No tienes notificaciones en este momento.</h2>
    </div>
    <style>
        .no-notifications-container {
            width: 80%;
            margin: 0 auto;
            background-color: rgba(173, 216, 230, 0.5);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</asp:Content>
