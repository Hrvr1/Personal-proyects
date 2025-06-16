<%@ Page Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="BandejaNotificacion.aspx.cs" Inherits="WebApplication.BandejaNotificacion" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Fondo azul claro */
            color: #333;
        }

        .filter-container, .notification-table {
            width: 80%;
            margin: 20px auto;
            background-color: rgba(173, 216, 230, 0.5); /* Fondo de filtro y tabla de notificaciones */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .custom-dropdown {
            font-family: Arial, sans-serif;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #007bff; 
            background-color: #f8f9fa; 
            color: #333;
            width: 200px;
            margin: 5px;
        }

        .custom-dropdown:hover {
            background-color: #e9ecef; 
        }

        .custom-dropdown:focus {
            outline: none;
            border-color: #0056b3;
        }

        .custom-dropdown option {
            font-size: 16px;
            padding: 10px;
            background-color: #fff;
            color: #333;
        }

        .custom-dropdown option:checked {
            background-color: #007bff;
            color: #fff; 
        }

        .filter-indicator {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
            margin: 5px;
        }

        .notification-item {
            width: 100%;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin-bottom: 10px;
            background-color: #e0f0ff; /* Azul ligeramente más oscuro */
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .notification-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .btn {
            padding: 10px 15px;
            margin: 5px 0;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-elimina {
            background-color: #dc3545;
            color: white;
            padding: 10px;
        }

        .btn-elimina:hover {
            background-color: #c82333;
        }

        .btn-ver-coche {
            background-color: #007bff;
            color: white;
            padding: 10px;
        }

        .btn-ver-coche:hover {
            background-color: #0056b3;
        }

        .vehicle-details {
            display: flex;
            align-items: center;
        }

        .image-container {
            flex-basis: 30%;
            text-align: center;
            margin-right: 20px; 
        }

        .image-container img {
            width: 300px; /* Tamaño original de la imagen */
            height: 200px;
            object-fit: cover;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5);
            border-radius: 5px;
        }

        .data-container {
            flex-basis: 50%;
            margin-right: 20px;
        }

        .data-container2 {
            flex-basis: 35%;
            text-align: right;
        }

        .empty-message-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="MainContent" runat="server">

    <div class="filter-container">
        <div class="filter-indicator">Filtrar por tipo de notificación:</div>
        <!-- DropDownList para filtrar por tipo de notificación -->
        <asp:DropDownList ID="ddlTipoNotificacion" runat="server" AutoPostBack="true" OnSelectedIndexChanged="ddlTipoNotificacion_SelectedIndexChanged"  CssClass="custom-dropdown">
        </asp:DropDownList>
    </div>

    <div class="notification-table">
        <asp:Repeater ID="resultsRepeater" runat="server" OnItemCommand="Repeater_ItemCommand">
            <ItemTemplate>
                <div class="notification-item">
                    <div class="data-container">
                        <h2><%# Eval("tipo_notificacion") %></h2>
                        <p><%# Eval("marca") %></p>
                        <p><%# Eval("modelo") %></p>
                        <p><%# Eval("fecha_notificacion", "{0:dd/MM/yyyy}") %></p>
                    </div>
                    <div class="vehicle-details">
                        <div class="image-container">
                            <img src='<%# Eval("url_imagen") %>' />
                        </div>
                        <div class="button-container">
                            <asp:Button ID="btnVerVehiculo" runat="server" Text="Ver Vehículo" CommandName="VerVehiculo" CommandArgument='<%# Eval("vehiculo_id") %>' CssClass="btn btn-ver-coche" />
                            <asp:Button ID="btnEliminar" runat="server" Text="Eliminar" CommandName="EliminarNotificacion" CommandArgument='<%# Eval("notificacion_id") %>' CssClass="btn btn-elimina"/>
                        </div>
                    </div>
                    <div class="data-container2">
                        <p><%# Eval("auto_manu") %></p>
                        <p><%# Eval("combustible") %></p>
                        <p><%# Eval("precio") %> €</p>
                        <p><%# Eval("kilometraje") %> km</p>
                    </div>
                </div>
            </ItemTemplate>
        </asp:Repeater>
    </div>
</asp:Content>
