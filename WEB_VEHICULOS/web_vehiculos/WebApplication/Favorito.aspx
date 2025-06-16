<%@ Page Title="Favoritos" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Favorito.aspx.cs" Inherits="WebApplication.Favorito" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
        }

        .filter-container, .notification-table, .carrito-table, .favorito-table {
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

        .notification-item, .carrito-item, .favorito-item {
            width: 100%;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin-bottom: 10px;
            background-color: #e0f0ff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .notification-item:hover, .carrito-item:hover, .favorito-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: center; 
        }

        .btn {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-elimina {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-elimina:hover {
            background-color: #c82333;
        }

        .btn-ver-coche {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
            position: relative; 
        }

        .btn-ver-coche:hover {
            background-color: #0056b3;
        }

        .btn-ver-coche::after {
            content: '\f06e';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            font-size: 14px;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .btn-ver-coche:hover::after {
            content: '\f070';
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
            width: 300px; 
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
            margin-left: 20px; 
        }

        .empty-message-container {
            text-align: center;
            margin-top: 20px;
        }


        .empty-message-container, .btn-ver-coche, .carrito-table, .favorito-table {
            display: block;
            margin: 10px auto 0;
        }
    </style>
</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="MainContent" runat="server">
    <div class="favorito-table">
        <asp:Panel ID="SinFavorito" runat="server" CssClass="empty-message-container" Visible="false">
            <asp:Label ID="lblEmptyMessage" runat="server" Text="No tienes vehiculos en la lista de favoritos. Visite el catálogo!" />
            <asp:Button ID="bttCatalogo" runat="server" Text="Catálogo" CssClass="btn-ver-coche" OnClick="IrCatalogo" />
        </asp:Panel>
        <asp:Repeater ID="favoritoRepeater" runat="server" OnItemCommand="Repeater_ItemCommand">
            <ItemTemplate>
                <div class="favorito-item">
                    <div class="data-container">
                        <p><%# Eval("modelo") %></p>
                        <p><%# Eval("marca") %></p>
                    </div>
                    <div class="vehicle-details">
                        <div class="image-container">
                            <p>
                                <img src='<%# Eval("url_imagen") %>' style="width: 300px; height: 200px; object-fit: cover; margin-left: -100px; box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5);" />
                            </p>
                        </div>
                        <div class="button-container">
                            <asp:Button ID="btnVerVehiculo" runat="server" Text="Ver Vehículo" CommandName="VerVehiculo" CommandArgument='<%# Eval("vehiculo_id") %>' CssClass="btn btn-ver-coche" />
                            <asp:Button ID="btnAddCarrito" runat="server" Text="Añadir a carrito" CommandName="AddCarrito" CommandArgument='<%# Eval("vehiculo_id") %>' CssClass="btn btn-ver-coche" />
                            <asp:Button ID="btnEliminar" runat="server" Text="Eliminar" CommandName="EliminarFavorito" CommandArgument='<%# Eval("lista_favorito_id") %>' CssClass="btn btn-elimina" />
                        </div>
                    </div>
                    <div class="data-container2" style="margin-left: auto;">
                        <p><%# Eval("auto_manu") %></p>
                        <p><%# Eval("combustible") %></p>
                        <p><%# Eval("precio") %> €</p>
                        <p><%# Eval("kilometraje") %> km</p>
                    </div>
                </div>
            </ItemTemplate>
        </asp:Repeater>
        <asp:Panel ID="TablaOpciones" runat="server" class="carrito-table" Visible="true">
            <asp:Button ID="Button1" runat="server" Text="Vaciar favorito" OnClick="VaciarFavoritoTodo" CssClass="btn btn-ver-coche" />
        </asp:Panel>
    </div>
</asp:Content>
