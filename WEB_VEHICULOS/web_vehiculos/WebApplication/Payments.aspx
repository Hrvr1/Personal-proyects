<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Payments.aspx.cs" Inherits="WebApplication.Payments" %>
<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <div class="container">
        <h2>Ingrese su información de método de pago</h2>
        <div class="form-group">
            <label for="txtNombre">Nombre en la Tarjeta:</label>
            <asp:TextBox ID="txtNombre" CssClass="form-control" runat="server"></asp:TextBox>
        </div>
        <div class="form-group">
            <label for="txtNumero">Número de Tarjeta:</label>
            <asp:TextBox ID="txtNumero" CssClass="form-control" runat="server"></asp:TextBox>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="ddlMes">Mes de Vencimiento:</label>
                <asp:DropDownList ID="ddlMes" CssClass="form-control" runat="server">
                    <asp:ListItem Text="Enero" Value="1"></asp:ListItem>
                    <asp:ListItem Text="Febrero" Value="2"></asp:ListItem>
                    <asp:ListItem Text="Enero" Value="1"></asp:ListItem>
                    <asp:ListItem Text="Febrero" Value="2"></asp:ListItem>
                    <asp:ListItem Text="Marzo" Value="3"></asp:ListItem>
                    <asp:ListItem Text="Abril" Value="4"></asp:ListItem>
                    <asp:ListItem Text="Mayo" Value="5"></asp:ListItem>
                    <asp:ListItem Text="Junio" Value="6"></asp:ListItem>
                    <asp:ListItem Text="Julio" Value="7"></asp:ListItem>
                    <asp:ListItem Text="Agosoto" Value="8"></asp:ListItem>
                    <asp:ListItem Text="Septiembre" Value="9"></asp:ListItem>
                    <asp:ListItem Text="Octubre" Value="10"></asp:ListItem>
                    <asp:ListItem Text="Noviembre" Value="11"></asp:ListItem>
                    <asp:ListItem Text="Diciembre" Value="12"></asp:ListItem>
                </asp:DropDownList>
            </div>
            <div class="form-group col-md-6">
                <label for="ddlAno">Año de Vencimiento:</label>
                    <asp:DropDownList ID="ddlAno" CssClass="form-control" runat="server">
                    <asp:ListItem Text="2024" Value="1"></asp:ListItem>
                    <asp:ListItem Text="2025" Value="2"></asp:ListItem>
                    <asp:ListItem Text="2026" Value="3"></asp:ListItem>
                    <asp:ListItem Text="2027" Value="4"></asp:ListItem>
                    <asp:ListItem Text="2028" Value="5"></asp:ListItem>
                    <asp:ListItem Text="2029" Value="6"></asp:ListItem>
                    <asp:ListItem Text="2030" Value="7"></asp:ListItem>
                    <asp:ListItem Text="2031" Value="8"></asp:ListItem>
                    <asp:ListItem Text="2032" Value="9"></asp:ListItem>
                    <asp:ListItem Text="2033" Value="10"></asp:ListItem>
                    <asp:ListItem Text="2034" Value="11"></asp:ListItem>
                </asp:DropDownList>
            </div>
        </div>
        <div class="form-group">
            <label for="txtCVV">CVV:</label>
            <asp:TextBox ID="txtCVV" CssClass="form-control" runat="server" MaxLength="3"></asp:TextBox>
        </div>
        <div class="text-right">
                    <h4><asp:Label ID="lblMensaje" runat="server"></asp:Label></h4>
                </div>
        <asp:Button ID="btnPagar" CssClass="btn btn-primary" runat="server" Text="Pagar" OnClick="btnPagar_Click" />
    </div>
</asp:Content>

