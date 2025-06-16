<%@ Page Title="Profile" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="user.aspx.cs" Inherits="WebApplication.user" %>
<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <style>
        .user-info {
            float: left;
            width: 25%;
            padding: 20px;
        }

        .profile-config {
            margin-left: 30%;
            padding: 20px;
        }

        .container {
            max-width: 900px;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-group .btn {
            width: 150px; /* Establecer un ancho fijo para todos los botones */
        }

        .profile-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .change-password-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }
    </style>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="user-info">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                <span class="font-weight-bold">
                    <asp:Label ID="lblUsername" runat="server" Text="yc"></asp:Label>
                </span>
            </div>
            <asp:Button ID="btnLogOut" runat="server" Text="Log Out" CssClass="btn btn-primary profile-button" OnClick="btnLogOut_Click" />
        </div>
        <div class="profile-config">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Configuracion del perfil</h4>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="labels">Nombre</label>
                        <asp:TextBox ID="txtName" runat="server" CssClass="form-control" placeholder="Nombre"></asp:TextBox>
                    </div>
                    <div class="col-md-6">
                        <label class="labels">Apellidos</label>
                        <asp:TextBox ID="txtSurname" runat="server" CssClass="form-control" placeholder="Apellidos"></asp:TextBox>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="labels">Telefono</label>
                        <asp:TextBox ID="txtMobileNumber" runat="server" CssClass="form-control" placeholder="Telefono"></asp:TextBox>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Calle</label>
                        <asp:TextBox ID="txtAddressLine1" runat="server" CssClass="form-control" placeholder="Calle"></asp:TextBox>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Codigo Postal</label>
                        <asp:TextBox ID="txtPostcode" runat="server" CssClass="form-control" placeholder="Codigo Postal"></asp:TextBox>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Ciudad</label>
                        <asp:TextBox ID="txtState" runat="server" CssClass="form-control" placeholder="Ciudad"></asp:TextBox>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Correo Electronico</label>
                        <asp:TextBox ID="txtEmailID" runat="server" CssClass="form-control" placeholder="Correo Electronico" TextMode="Email"></asp:TextBox>
                    </div>
                    <div class="col-md-12">
                        <label class="labels">Estado/Provincia</label>
                        <asp:TextBox ID="txtArea" runat="server" CssClass="form-control" placeholder="Estado/Provincia"></asp:TextBox>
                    </div>
                </div>
                <div class="profile-actions">
                    <asp:Button ID="btnBuy" runat="server" Text="Comprar" CssClass="btn btn-primary profile-button" OnClick="btncompra_Click" />
                    <asp:Button ID="btnPostAds" runat="server" Text="Publicar anuncios" CssClass="btn btn-primary profile-button" OnClick="btnSell_Click" />
                    <asp:Button ID="btnMyOrders" runat="server" Text="Mis pedidos" CssClass="btn btn-primary profile-button" OnClick="btnpedido_Click" />
                </div>
                <div class="mt-5 text-center">
                    <asp:Label ID="lblSuccessMessage" runat="server" CssClass="text-success" Visible="false"></asp:Label>
                    <asp:Label ID="lblErrorMessage" runat="server" CssClass="text-danger" Visible="false"></asp:Label>
                    <asp:Button ID="btnSaveProfile" runat="server" Text="Guardar perfil" CssClass="btn btn-primary profile-button" OnClick="btnSaveProfile_Click" Visible="false" />
                </div>
                <div class="mt-3 text-center">
                    <div class="btn-group">
                        <asp:Button ID="btnEditProfile" runat="server" Text="Editar perfil" CssClass="btn btn-primary profile-button" OnClick="btnEditProfile_Click" />
                        <asp:Button ID="btnChangePassword" runat="server" Text="Cambiar contraseña" CssClass="btn btn-primary profile-button" OnClick="btnChangePassword_Click" />
                        <asp:Button ID="btnDeleteAccount" runat="server" Text="Eliminar cuenta" CssClass="btn btn-primary profile-button" OnClick="btnDeleteAccount_Click" />
                        <asp:Button ID="btnAdmin" runat="server" Text="Admin" CssClass="btn profile-button" OnClick="btnAdmin_Click" Visible='<%# IsAdminVisible() %>' 
                            Style="background-color: green; border-color: green; color: white;" />
                    </div>
                </div>
                <div id="changePasswordFields" runat="server" Visible="false">
                    <div>
                        <label class="labels">Nueva Contraseña</label>
                        <asp:TextBox ID="txtNewPassword" runat="server" CssClass="form-control" TextMode="Password" placeholder="Nueva Contraseña"></asp:TextBox>
                    </div>
                    <div>
                        <label class="labels">Confirmar Contraseña</label>
                        <asp:TextBox ID="txtConfirmPassword" runat="server" CssClass="form-control" TextMode="Password" placeholder="Confirmar Contraseña"></asp:TextBox>
                    </div>
                    <div class="change-password-buttons">
                        <asp:Button ID="btnSubmitPasswordChange" runat="server" Text="Cambiar contraseña" CssClass="btn btn-primary profile-button" OnClick="btnSubmitPasswordChange_Click" />
                        <asp:Button ID="btnCancelPasswordChange" runat="server" Text="Cancelar" CssClass="btn btn-secondary profile-button" OnClick="btnCancelPasswordChange_Click" />
                    </div>
                </div>
                <asp:Panel ID="pnlConfirmDelete" runat="server" CssClass="panel panel-danger" Visible="false">
                    <div class="panel-heading">
                        <h4 class="panel-title">Confirmar eliminación de cuenta</h4>
                    </div>
                    <div class="panel-body">
                        <p>¿Está seguro que desea eliminar su cuenta? Esta acción no se puede deshacer.</p>
                        <asp:Button ID="btnConfirmDelete" runat="server" Text="Confirmar" CssClass="btn btn-danger" OnClick="btnConfirmDelete_Click" />
                        <asp:Button ID="btnCancelDelete" runat="server" Text="Cancelar" CssClass="btn btn-default" OnClick="btnCancelDelete_Click" />
                    </div>
                </asp:Panel>
            </div>
        </div>
    </div>
</asp:Content>   
