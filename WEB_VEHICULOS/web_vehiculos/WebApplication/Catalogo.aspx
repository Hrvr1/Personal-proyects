<%@ Page Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Catalogo.aspx.cs" Inherits="WebApplication.Catalogo" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <!-- Botón de filtros -->
    <div id="filterButtonContainer">
        <div id="filterButton">
            <img id="filterButtonImage" src="App_Images/icons/filtros_gris.png" alt="Filtros" />
        </div>
    </div>

    <!-- Filtros -->
    <div id="filterContainer">
        <div id="filterContent">
            <div class="filter-group-horizontal">
                <!-- Marca -->
                <div class="custom-select">
                    <asp:DropDownList ID="ddlMarca" runat="server" AppendDataBoundItems="true" CssClass="filter">
                        <asp:ListItem Text="Marca" Value="" Selected="True"></asp:ListItem>
                    </asp:DropDownList>
                </div>
                <!-- Modelo -->
                <div class="custom-input">
                    <asp:TextBox ID="txtModelo" runat="server" CssClass="filter" placeholder="Modelos"></asp:TextBox>
                </div>
                <!-- Año -->
                <div class="custom-input">
                    <asp:TextBox ID="txtAnyoMin" runat="server" CssClass="filter" placeholder="Fecha de matriculación"></asp:TextBox>
                </div>
                <!-- Combustible -->
                <div class="custom-select">
                    <asp:DropDownList ID="ddlCombustible" runat="server" CssClass="filter">
                        <asp:ListItem Text="Combustible" Value=""></asp:ListItem>
                        <asp:ListItem Text="Gasolina" Value="Gasolina"></asp:ListItem>
                        <asp:ListItem Text="Diesel" Value="Diesel"></asp:ListItem>
                        <asp:ListItem Text="Eléctrico" Value="Eléctrico"></asp:ListItem>
                        <asp:ListItem Text="Híbrido" Value="Híbrido"></asp:ListItem>
                    </asp:DropDownList>
                </div>
                <!-- Transmisión -->
                <div class="custom-select">
                    <asp:DropDownList ID="ddlTransmision" runat="server" CssClass="filter">
                        <asp:ListItem Text="Transmisión" Value=""></asp:ListItem>
                        <asp:ListItem Text="Manual" Value="Manual"></asp:ListItem>
                        <asp:ListItem Text="Automático" Value="Automático"></asp:ListItem>
                    </asp:DropDownList>
                </div>
            </div>
            <!-- Precio y Kilometraje -->
            <div class="filter-group-horizontal">
                <!-- Precio -->
                <div class="range-filter">
                    <label for="priceRange">Precio:</label>
                    <div class="slider-container">
                        <input type="range" id="priceRangeMin" name="priceRangeMin" min="0" max="100000" step="10" value="0" oninput="updatePriceRange()">
                        <input type="range" id="priceRangeMax" name="priceRangeMax" min="0" max="100000" step="10" value="100000" oninput="updatePriceRange()">
                    </div>
                    <span id="priceRangeLabel">€ 0 - € 100000</span>
                </div>
                <!-- Kilometraje -->
                <div class="range-filter">
                    <label for="kmRange">Kilometraje:</label>
                    <div class="slider-container">
                        <input type="range" id="kmRangeMin" name="kmRangeMin" min="0" max="400000" step="1000" value="0" oninput="updateKmRange()">
                        <input type="range" id="kmRangeMax" name="kmRangeMax" min="0" max="400000" step="1000" value="400000" oninput="updateKmRange()">
                    </div>
                    <span id="kmRangeLabel">0 km - 400000 km</span>
                </div>
            </div>

            <!-- Botón de aplicar filtros -->
            <asp:Button ID="btnApplyFilters" runat="server" CssClass="filterButton" Text="Aplicar filtros" OnClick="btnApplyFilters_Click" />
        </div>
    </div>

    <!-- Catálogo de vehículos -->
    <div id="vehicleCatalog">
        <asp:Repeater ID="resultsRepeater" runat="server">
            <ItemTemplate>
                <div class="vehicleCard<%# (Eval("vendido").ToString() == "1") ? " sold" : "" %>">
                    <a href='<%# "Vehiculo.aspx?id=" + Eval("vehiculo_id") %>'>
                        <img src='<%# Eval("url_imagen") %>' alt='<%# Eval("marca") %> <%# Eval("modelo") %>' class="vehicleImage" />
                    </a>
                    <div class="vehicleInfo">
                        <h2><%# Eval("marca") %> <%# Eval("modelo") %></h2>
                        <p><%# Eval("precio") %> €</p>
                        <p><%# Eval("anyo") %> • <%# Eval("combustible") %> • <%# Eval("kilometraje") %> km</p>
                        <p><%# Eval("auto_manu") %></p>
                        <asp:Label ID="lblVendido" runat="server" Text="Vendido" Visible='<%# Convert.ToBoolean(Eval("vendido")) %>' CssClass="vendido-label"></asp:Label>
                    </div>
                    <div class="button-container">
                        <asp:Button ID="btnFavoritos" runat="server" Text="❤ Añadir a Favoritos" CommandName="Favoritos" CommandArgument='<%# Eval("vehiculo_id") %>' OnClick="AccionVehiculo_Click" CssClass="btn btn-favoritos" />
                        <asp:Button ID="btnCarrito" runat="server" Text="🛒 Añadir a Carrito" CommandName="Carrito" CommandArgument='<%# Eval("vehiculo_id") %>' OnClick="AccionVehiculo_Click" CssClass="btn btn-carrito" />
                        <asp:Button ID="btnCompra" runat="server" Text="💶​ Compra Ya" CommandName="Compra" CommandArgument='<%# Eval("vehiculo_id") %>' OnClick="AccionVehiculo_Click" CssClass="btn btn-compra" />
                    </div>
                </div>
            </ItemTemplate>
        </asp:Repeater>
    </div>

    <style>
        /* Estilos generales de la página */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        #MainContent {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Estilos del botón de filtros */
        #filterButtonContainer {
            text-align: center;
            margin-bottom: 20px;
        }

        #filterButton {
            width: 60px;
            height: 60px;
            background-color: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
            margin: 0 auto;
        }

        #filterButton:hover {
            transform: scale(1.1);
            background-color: #0056b3;
        }

        #filterButtonImage {
            width: 30px;
            height: 30px;
        }

        /* Estilos del contenedor de filtros */
        #filterContainer {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.5s ease-in-out;
            margin-bottom: 20px;
            padding: 0 20px;
        }

        #filterContainer.show {
            max-height: 1000px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #filterContent {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .filter-group-horizontal {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-between;
        }

        .filter {
            padding: 10px;
            font-size: 14px;
            flex: 1;
            min-width: 150px; /* Asegura un tamaño mínimo para que no se colapsen */
            margin: 5px;
        }

        .custom-select, .custom-input {
            flex: 1;
        }

        .custom-select select, .custom-input input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .range-filter {
            flex: 1;
            min-width: 200px;
            padding: 10px;
            font-size: 14px;
        }

        .slider-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .slider-container input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 5px;
            background: #ddd;
            outline: none;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .slider-container input[type="range"]:hover {
            opacity: 1;
        }

        .slider-container input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 15px;
            height: 15px;
            background: #007bff;
            cursor: pointer;
            border-radius: 50%;
        }

        .slider-container input[type="range"]::-moz-range-thumb {
            width: 15px;
            height: 15px;
            background: #007bff;
            cursor: pointer;
            border-radius: 50%;
        }

        .filterButton {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filterButton:hover {
            background-color: #0056b3;
        }

        /* Estilos de las tarjetas de vehículos */
        #vehicleCatalog {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 0 20px;
        }

        .vehicleCard {
            width: calc(50% - 20px); /* Dos vehículos por fila con un gap de 20px */
            border: 1px solid #ddd;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .vehicleCard.sold {
            border: 2px solid red;
            background-color: #ffcccc;
        }

        .vehicleImage {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .vehicleInfo {
            text-align: center;
            padding: 10px;
        }

        .vehicleInfo h2 {
            font-size: 18px;
            margin: 10px 0;
        }

        .vehicleInfo p {
            margin: 5px 0;
        }

        .viewButton {
            padding: 10px 20px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .viewButton:hover {
            background-color: #0056b3;
        }

        .button-container {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 15px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-favoritos {
            background-color: #ff4757;
        }

        .btn-favoritos:hover {
            background-color: #e84118;
        }

        .btn-carrito {
            background-color: #0056b3;
        }

        .btn-carrito:hover {
            background-color: deepskyblue;
        }

        .btn-compra {
            background-color: #2ed573;
        }

        .btn-compra:hover {
            background-color: #27ae60;
        }

        .vendido-label {
            display: block;
            color: white;
            background-color: red;
            font-weight: bold;
            padding: 5px;
            text-align: center;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>

    <script>
        // Función para desplegar y plegar el contenedor de filtros
        document.getElementById('filterButton').addEventListener('click', function () {
            var filterContainer = document.getElementById('filterContainer');
            if (filterContainer.classList.contains('show')) {
                filterContainer.classList.remove('show');
            } else {
                filterContainer.classList.add('show');
            }
        });

        // Función para actualizar el rango de precio mostrado
        function updatePriceRange() {
            var minPrice = document.getElementById('priceRangeMin').value;
            var maxPrice = document.getElementById('priceRangeMax').value;
            document.getElementById('priceRangeLabel').innerText = '€ ' + minPrice + ' - ' + maxPrice;
        }

        // Función para actualizar el rango de kilometraje mostrado
        function updateKmRange() {
            var minKm = document.getElementById('kmRangeMin').value;
            var maxKm = document.getElementById('kmRangeMax').value;
            document.getElementById('kmRangeLabel').innerText = minKm + ' km - ' + maxKm + ' km';
        }
    </script>
</asp:Content>
