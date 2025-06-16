<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="AdminPage.aspx.cs" Inherits="WebApplication.AdminPage" %>

<asp:Content ID="Content2" ContentPlaceHolderID="MainContent" runat="server">
    <h2>Administración</h2>
    
    <asp:Button ID="btnMostrarUsuarios" runat="server" Text="Ver Usuarios" OnClick="ButtonMostrarUsuarios_Click" 
        style="background-color: #007BFF; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;" />
    <asp:Button ID="btnMostrarVehiculos" runat="server" Text="Ver vehiculos" OnClick="ButtonMostrarVehiculos_Click" 
        style="background-color: #007BFF; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;" />

    <asp:Panel ID="PanelUsuarios" runat="server" Visible="false">
        <h2>Administrar Usuarios</h2>
        <asp:GridView ID="GridViewUsuarios" runat="server" AutoGenerateColumns="False" OnRowCommand="GridViewUsuarios_RowCommand">
            <Columns>
                <asp:BoundField DataField="Username" HeaderText="Username" />
                <asp:BoundField DataField="Nombre" HeaderText="Nombre" />
                <asp:BoundField DataField="Apellidos" HeaderText="Apellidos" />
                <asp:BoundField DataField="Email" HeaderText="Email" />
                <asp:BoundField DataField="Telefono" HeaderText="Telefono" />
                <asp:BoundField DataField="Calle" HeaderText="Calle" />
                <asp:BoundField DataField="Localidad" HeaderText="Localidad" />
                <asp:BoundField DataField="Provincia" HeaderText="Provincia" />
                <asp:BoundField DataField="Codigo_Postal" HeaderText="Codigo Postal" />
                <asp:BoundField DataField="Admin" HeaderText="Admin" DataFormatString="{0}" />
                <asp:TemplateField>
                    <ItemTemplate>
                         <asp:Button ID="btnDelete" runat="server" Text="Eliminar" CommandName="DeleteUser" CommandArgument='<%# Eval("Username") %>' CssClass="btn btn-danger" Visible='<%# Convert.ToInt32(Eval("Admin")) == 0 %>' />
                    </ItemTemplate>
                </asp:TemplateField>
            </Columns>
        </asp:GridView>
        
        <asp:Label ID="lblSuccessMessage" runat="server" CssClass="text-success" Visible="false"></asp:Label>
        <asp:Label ID="lblErrorMessage" runat="server" CssClass="text-danger" Visible="false"></asp:Label>
    </asp:Panel>

   <asp:Panel ID="PanelArticulos" runat="server" Visible="false">
    <h2>Administrar vehiculos</h2>
    <asp:GridView ID="GridViewVehiculos" runat="server" AutoGenerateColumns="False" OnRowCommand="GridViewVehiculos_RowCommand">
        <Columns>
            <asp:BoundField DataField="vehiculo_id" HeaderText="ID" />
            <asp:BoundField DataField="marca_id" HeaderText="Marca" />
            <asp:BoundField DataField="modelo" HeaderText="Modelo" />
            <asp:BoundField DataField="precio" HeaderText="Precio" DataFormatString="{0:C}" />
            <asp:BoundField DataField="vendido" HeaderText="Vendido" />
            <asp:TemplateField>
                <ItemTemplate>
                    <asp:Button ID="btnDeleteArticulo" runat="server" Text="Eliminar" CommandName="DeleteArticulo" CommandArgument='<%# Eval("vehiculo_id") %>' CssClass="btn btn-danger" />
                    <asp:Button ID="btnToggleVendido" runat="server" Text='<%# Eval("vendido").ToString() == "Si" ? "Marcar como no vendido" : "Marcar como vendido" %>' CommandName="ToggleVendido" CommandArgument='<%# Eval("vehiculo_id") %>' CssClass="btn btn-primary" />
                </ItemTemplate>
            </asp:TemplateField>
        </Columns>
    </asp:GridView>
    
    <asp:Label ID="lblArticuloSuccessMessage" runat="server" CssClass="text-success" Visible="false"></asp:Label>
    <asp:Label ID="lblArticuloErrorMessage" runat="server" CssClass="text-danger" Visible="false"></asp:Label>
</asp:Panel>
    <asp:Panel ID="PanelMejoras" runat="server" Visible="true">
    
    <h3>Panel de Mejoras</h3>
    
    <asp:Button ID="btnMostrarPaginaCompleta" runat="server" Text="Panel de control" OnClick="btnMostrarPaginaCompleta_Click" CssClass="btn btn-primary" />
</asp:Panel>
      



</asp:Content>
