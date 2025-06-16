<%@ Page Title="Factura del Pedido" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Pedido.aspx.cs" Inherits="WebApplication.Pedido" %>

<asp:Content ID="Content1" ContentPlaceHolderID="head" runat="server">
        <style>
                 .favorito-item, .notification-item {
            width: 100%;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin-bottom: 10px;
        }
                 .vehicle-details {
            display: flex;
            align-items: center;
        }

        .image-container {
            flex-basis: 30%;
            text-align: center;
        }

        .data-container {
            flex-basis: 50%;
            margin-right: 20px;
        }

        .data-container2 {
            flex-basis: 35%;
            margin-left: 20px;
            text-align: right;
        }
        </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
</asp:Content>

<asp:Content ID="Content2" ContentPlaceHolderID="MainContent" runat="server">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Factura del Pedido</h3>
            </div>
            <div class="card-body">
                <asp:Label ID="lblMensaje" runat="server" CssClass="text-danger" Visible="false"></asp:Label>
                <asp:Repeater ID="lineapedidoRepeater" runat="server">
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
                <div class="text-right">
                    <h4>Total: <asp:Label ID="lblTotal" runat="server"></asp:Label>€</h4>
                </div>
                <asp:Button ID="btnPagar" runat="server" CssClass="btn btn-primary mt-3" Text="Pagar" OnClick="btnPagar_Click" />
            </div>
        </div>
    </div>
</asp:Content>

