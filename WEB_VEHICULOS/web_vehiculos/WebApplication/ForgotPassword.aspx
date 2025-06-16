<%@ Page Title="Reset Your Password" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="ForgotPassword.aspx.cs" Inherits="WebApplication.ForgotPassword" %>
<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <div class="container">
        <h2>Rrestablece tu contraseña</h2>  
        <asp:Panel ID="pnlForm" runat="server">  
            <p>Le enviaremos un correo electrónico para restablecer su contraseña.</p>
            <p>
                <asp:Image ID="Image1" runat="server" ImageUrl="logimg/voiture.png" Height="100px" Width="179px"/>
            </p>
            <asp:Label ID="lblEmail" runat="server" Text="Email" AssociatedControlID="txtEmail"></asp:Label>
            <asp:TextBox ID="txtEmail" runat="server" CssClass="form-control" AutoCompleteType="Email" required="required"></asp:TextBox>
            <asp:Button ID="btnSubmit" runat="server" Text="SUBMIT" CssClass="btn btn-primary" OnClick="btnSubmit_Click" />
            <asp:Button ID="btnCancel" runat="server" Text="Cancel" CssClass="btn btn-default" OnClientClick="window.location='Login.aspx';return false;" />
            <asp:Label ID="lblErrorMessage" runat="server" Text="" Visible="false" />
        </asp:Panel>
        <asp:Panel ID="pnlConfirmation" runat="server" Visible="false">
            <p>Te hemos enviado un correo electrónico que contiene tus datos y contraseña</p>
            <asp:HyperLink ID="lnkSignIn" runat="server" NavigateUrl="~/login.aspx" Text="Sign In"></asp:HyperLink>
        </asp:Panel>
    </div>
</asp:Content>
