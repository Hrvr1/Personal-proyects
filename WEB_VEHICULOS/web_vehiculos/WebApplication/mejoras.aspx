<%@ Page Title="mejoras" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="mejoras.aspx.cs" Inherits="WebApplication.mejoras" %>

<asp:Content ID="Content2" ContentPlaceHolderID="MainContent" runat="server">
    <style>
        * {
            box-sizing: border-box;   
        }
        html {
            font-family: "system-ui";
        }
        body {
            background-color: hsl(60, 10%, 93%);
            display: grid;
            place-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .unodos {
            display: grid;
            gap: 1rem;
            grid-template-columns: minmax(auto, 70%) minmax(auto, 30%);
            margin-bottom: 1rem;
        }
        .header-contactos {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .wrapper {
            max-width: 1100px;
            width: 100%;
            margin: 2rem 3rem;
        }
        .wrapper-main {
            border-radius: 3vmin;
            background-color: white;
            width: 100%;
            padding: 1rem 1rem;
        }
        .main-table-container {
            border-radius: 3vmin;
            background-color: white;
            max-width: 1100px;
            width: 100%;
            padding: 1rem 1rem;
        }
        .title-table-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0rem 1.5rem;
            margin-bottom: 1rem;
        }
        tbody {
            font-weight: 600;
        }
        .subtitle {
            font-weight: 600;
        }
        .select-button {
            padding: 0.45rem 1rem;
            padding-right: 1.5rem;
            position: relative;
            border-radius: 0.5rem;
            border: 2px solid lightgrey;
            font-weight: 600;
            background-color: transparent;
            cursor: pointer;
            transition: background-color 0.25s;
        }
        .select-button:hover {
            background-color: #f6f6f4;
        }
        .select-button:after {
            content: " ";
            position: absolute;
            height: 0.7vmin;
            width: 0.7vmin;
            border: 1px solid black;
            border-bottom: none;
            border-left: none;
            right: 10%;
            top: 30%;
            transform: rotate(134deg);
        }
        .dot {
            height: 15px;
            width: 15px;
        }
        table {
            width: 100%;
            font-weight: 600;
            font-size: 13px;
            border-collapse: collapse;
            color: #474747;
        }
        tr {
            transition: background-color 0.2s;
        }
        tr:hover {
            background-color: #f6f6f4;
        }
        td {
            padding: 0.5rem;
            border: none;
            text-align: center;
        }
        td:first-child {
            border-radius: 1.5rem 0rem 0rem 1.5rem;
            text-align: left;
        }
        td:last-child {
            border-radius: 0rem 1.5rem 1.5rem 0rem;
        }
        .icono-texto {
            display: flex;
            align-items: center;
        }
        .icono-texto > div {
            margin-left: 10px;
        }
        .contenedor-svg {
            background-color: #e090c9;
            border-radius: 0.7rem;
            padding: 10px;
        }
        .dolar {
            height: 15px;
            width: 15px;
        }
        .pendiente {
            background-color: #fbf3ea;
            color: #e8aa71;
            padding: 0.5rem;
            border-radius: 1rem;
            max-width: 116px;
        }
        .completado {
            background-color: #ebf0ed;
            color: #80aba4;
            padding: 0.5rem;
            border-radius: 1rem;
            max-width: 116px;
        }
        .cancelado {
            background-color: #f7e9e8;
            color: #cf5858;
            padding: 0.5rem;
            border-radius: 1rem;
            max-width: 116px;
        }
        .otro-dolar {
            background-color: #b3afec;
        }
        .contenedor-totales {
            display: flex;
            gap: 2rem;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 1rem;
        }
        .total-recuadro {
            gap: 1rem;
            display: flex;
            align-items: center;
        }
        .texto-numero {
            font-size: 1rem;
            color: #7d7d7d;
        }
        .numero {
            font-weight: 600;
            font-size: clamp(0.5rem, 2vw, 1.5rem);
        }
        .contenedor-ico-mayor {
            background-color: #f6f6f4;
            border-radius: 1.4rem;
            display: grid;
            place-items: center;
            height: 4.5rem;
            width: 4.5rem;
        }
        .contenedor-icono {
            padding: 0.7rem;
            display: grid;
            place-items: center;
            border-radius: 0.7rem;
            outline: 1px solid white;
        }
        .contenedor-icono > svg {
            height: 0.7rem;
            width: auto;
            fill: white;
        }
        .rosa {
            background-color: #e090c9;
        }
        .amarillo {
            fill: #f9b87a !important;
            height: 2.3rem !important;
            width: 2.3rem !important;
        }
        .lila {
            background-color: #b3afec;
        }
        .contenedor-chart {
            width: 100%;
            height: 70%;
        }
        canvas {
            width: 100%;
            height: 200px !important;
        }
        @media (max-width: 750px) {
            td:nth-child(2) {
                display: none;
            }
            td:nth-child(3) {
                display: none;
            }
        }
    </style>

    <div class="wrapper">
        <div class="unodos">
            <div class="wrapper-main">
                <div class="contenedor-totales">
                    <div class="total-recuadro">
                        <div class="contenedor-ico-mayor">
                            <div class="contenedor-icono lila">
                                <svg viewBox="0 0 576 512" width="100" title="hand-holding-usd">
                                    <path d="M271.06,144.3l54.27,14.3a8.59,8.59,0,0,1,6.63,8.1c0,4.6-4.09,8.4-9.12,8.4h-35.6a30,30,0,0,1-11.19-2.2c-5.24-2.2-11.28-1.7-15.3,2l-19,17.5a11.68,11.68,0,0,0-2.25,2.66,11.42,11.42,0,0,0,3.88,15.74,83.77,83.77,0,0,0,34.51,11.5V240c0,8.8,7.83,16,17.37,16h17.37c9.55,0,17.38-7.2,17.38-16V222.4c32.93-3.6,57.84-31,53.5-63-3.15-23-22.46-41.3-46.56-47.7L282.68,97.4a8.59,8.59,0,0,1-6.63-8.1c0-4.6,4.09-8.4,9.12-8.4h35.6A30,30,0,0,1,332,83.1c5.23,2.2,11.28,1.7,15.3-2l19-17.5A11.31,11.31,0,0,0,368.47,61a11.43,11.43,0,0,0-3.84-15.78,83.82,83.82,0,0,0-34.52-11.5V16c0-8.8-7.82-16-17.37-16H295.37C285.82,0,278,7.2,278,16V33.6c-32.89,3.6-57.85,31-53.51,63C227.63,119.6,247,137.9,271.06,144.3ZM565.27,328.1c-11.8-10.7-30.2-10-42.6,0L430.27,402a63.64,63.64,0,0,1-40,14H272a16,16,0,0,1,0-32h78.29c15.9,0,30.71-10.9,33.25-26.6a31.2,31.2,0,0,0,.46-5.46A32,32,0,0,0,352,320H192a117.66,117.66,0,0,0-74.1,26.29L71.4,384H16A16,16,0,0,0,0,400v96a16,16,0,0,0,16,16H372.77a64,64,0,0,0,40-14L564,377a32,32,0,0,0,1.28-48.9Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="contenedor-textos">
                            <div class="texto-numero">Ganancias Totales</div>
                            <div class="numero">€<%= TotalGanancias.ToString("N2") %></div>
                        </div>
                    </div>
                    <div class="total-recuadro">
                        <div class="contenedor-ico-mayor">
                            <div class="contenedor-icono rosa">
                                <svg viewBox="0 0 576 512" width="100" title="hammer">
                                    <path d="M571.31 193.94l-22.63-22.63c-6.25-6.25-16.38-6.25-22.63 0l-11.31 11.31-28.9-28.9c5.63-21.31.36-44.9-16.35-61.61l-45.25-45.25c-62.48-62.48-163.79-62.48-226.28 0l90.51 45.25v18.75c0 16.97 6.74 33.25 18.75 45.25l49.14 49.14c16.71 16.71 40.3 21.98 61.61 16.35l28.9 28.9-11.31 11.31c-6.25 6.25-6.25 16.38 0 22.63l22.63 22.63c6.25 6.25 16.38 6.25 22.63 0l90.51-90.51c6.23-6.24 6.23-16.37-.02-22.62zm-286.72-15.2c-3.7-3.7-6.84-7.79-9.85-11.95L19.64 404.96c-25.57 23.88-26.26 64.19-1.53 88.93s65.05 24.05 88.93-1.53l238.13-255.07c-3.96-2.91-7.9-5.87-11.44-9.41l-49.14-49.14z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="contenedor-textos">
                            <div class="texto-numero">Gastos Totales</div>
                            <div class="numero">€<%= TotalGastos.ToString("N2") %></div>
                        </div>
                    </div>
                    <div class="total-recuadro">
                        <div class="contenedor-ico-mayor">
                            <svg class="amarillo" viewBox="0 0 576 512" width="100" title="star">
                                <path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path>
                            </svg>
                        </div>
                        <div class="contenedor-textos">
                            <div class="texto-numero">Meta Mensual</div>
                            <div class="numero">€<%= MetaMensual.ToString("N2") %></div>
                        </div>
                    </div>
                </div>
                <div class="contenedor-chart">
                    <div class="title-table-container padding-0">
                        <div class="subtitle">Flujo de Dinero</div>
                        <button class="select-button">Mensual</button>
                    </div>
                    <canvas id="canvas5"></canvas>
                </div>
            </div>
            <div class="right wrapper-main">
                <div class="contactos">
                    <div class="header-contactos">
                        <div class="subtitle">&nbsp; Top&nbsp; 10 Clientes:</div>
                        <ul id="topClientsList"></ul>
                        <svg class="dot" viewBox="0 0 512 512" width="100" title="ellipsis-h">
                            <path d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72zm-352 0c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z"></path>
                        </svg>
                    </div>
                    <div class="body-contactos"></div>
                </div>
            </div>
        </div>
        <div class="main-table-container">
            <div class="title-table-container">
                <div class="subtitle">Transacciones</div>
                <button class="select-button">Reciente</button>
            </div>
            <div>
                <table>
                    <tbody id="transactionsTable">
                       
                    </tbody>
                </table>
            </div>
        </div>
        <div class="main-table-container">
            <div class="title-table-container">
                <div class="subtitle">Top 10 Productos Vendidos</div>
            </div>
            <div>
                <table id="topProductsTable">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Precio</th>
                            <th>Vendedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Datos para la gráfica
            const ctx5 = document.getElementById("canvas5").getContext('2d');
            new Chart(ctx5, {
                type: "line",
                data: {
                    labels: <%= Labels %>,
                    datasets: [
                        {
                            label: "Ventas",
                            data: <%= SalesData %>,
                            borderWidth: 1,
                            fill: true,
                            backgroundColor: "rgb(110 167 153 / 80%)",
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    weight: 600,
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });

            // Lista de los 10 mejores clientes
            const topClients = <%= TopClients %>;
            const topClientsList = document.getElementById('topClientsList');
            topClients.forEach(client => {
                const li = document.createElement('li');
                li.className = 'list-item';
                li.textContent = client;
                topClientsList.appendChild(li);
            });

            // Tabla de transacciones
            const transactions = <%= Transacciones %>;
            const transactionsTable = document.getElementById('transactionsTable');
            transactions.forEach(transaction => {
                const row = transactionsTable.insertRow();
                const statusClass = transaction.Estado.toLowerCase();
                row.innerHTML = `
                    <td>
                        <div class="icono-texto">
                            <div class="contenedor-svg"></div>
                            <div>${transaction.Cliente}</div>
                        </div>
                    </td>
                    <td>${transaction.Fecha}</td>
                    <td>${transaction.Modelo}</td>
                    <td>${transaction.Marca}</td>
                    <td>
                        <div class="${statusClass}">${transaction.Estado}</div>
                    </td>
                    <td>€${transaction.Precio.toFixed(2)}</td>
                    <td><svg class="dot" viewBox="0 0 512 512" width="100" title="ellipsis-h">
                        <path d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z"></path>
                    </svg></td>
                `;
            });

            // Tabla de los 10 productos más vendidos
            const topProducts = <%= TopProducts %>;
            const topProductsTable = document.getElementById('topProductsTable').getElementsByTagName('tbody')[0];
            topProducts.forEach(product => {
                const row = topProductsTable.insertRow();
                row.insertCell(0).textContent = product.Producto;
                row.insertCell(1).textContent = product.Marca;
                row.insertCell(2).textContent = product.Modelo;
                row.insertCell(3).textContent = product.Precio;
                row.insertCell(4).textContent = product.Vendedor;
            });
        });
    </script>
</asp:Content>
