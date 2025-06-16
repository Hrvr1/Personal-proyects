<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="register.aspx.cs" Inherits="WebApplication.register" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <style>
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-primary {
            width: 100%;
        }
        .form-footer {
            text-align: center;
            margin-top: 20px;
        }
        .text-danger {
            color: #dc3545 !important;
        }
    </style>

    <div class="register-container">
        <h2>Registro</h2>
        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtUsername" Width="200px">Nombre de Usuario:</asp:Label>
            <asp:TextBox ID="txtUsername" runat="server" placeholder="Username" CssClass="form-control" required="required"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvUsername" runat="server" ControlToValidate="txtUsername" ErrorMessage="El nombre de usuario es obligatorio." CssClass="text-danger" Display="Dynamic" />
            <asp:RegularExpressionValidator ID="revUsername" runat="server" ControlToValidate="txtUsername" ErrorMessage="El nombre de usuario debe ser una abreviatura de las iniciales del nombre y  del primer apellido seguidas de dos dígitos." CssClass="text-danger" Display="Dynamic" ValidationExpression="^[A-Za-z]{2}\d{2}$" />
            <asp:CustomValidator ID="cvUsernameInUse" runat="server" ControlToValidate="txtUsername" ErrorMessage="El nombre de usuario ya está en uso." CssClass="text-danger" Display="Dynamic" OnServerValidate="ValidateUsernameInUse" />
        </div>
        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtNombre">Nombre:</asp:Label>
            <asp:TextBox ID="txtNombre" runat="server" placeholder="First Name" CssClass="form-control" required="required"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvNombre" runat="server" ControlToValidate="txtNombre" ErrorMessage="El nombre es obligatorio." CssClass="text-danger" Display="Dynamic" />
        </div>
        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtApellidos">Apellidos:</asp:Label>
            <asp:TextBox ID="txtApellidos" runat="server" placeholder="Last Name" CssClass="form-control" required="required"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvApellidos" runat="server" ControlToValidate="txtApellidos" ErrorMessage="Los apellidos son obligatorios." CssClass="text-danger" Display="Dynamic" />
        </div>
        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtTelefono">Teléfono:</asp:Label>
            <asp:TextBox ID="txtTelefono" runat="server" placeholder="Phone" CssClass="form-control"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvTelefono" runat="server" ControlToValidate="txtTelefono" ErrorMessage="El teléfono es obligatorio." CssClass="text-danger" Display="Dynamic" />
            <asp:RegularExpressionValidator ID="revTelefono" runat="server" ControlToValidate="txtTelefono" ErrorMessage="El teléfono debe tener exactamente 9 dígitos." CssClass="text-danger" Display="Dynamic" ValidationExpression="^\d{9}$" />
            <asp:CustomValidator ID="cvTelefonoInUse" runat="server" ControlToValidate="txtTelefono" ErrorMessage="El número de teléfono ya está en uso." CssClass="text-danger" Display="Dynamic" OnServerValidate="ValidateTelefonoInUse" />
        </div>
       <div class="form-group">
    <asp:Label runat="server" AssociatedControlID="txtEmail">Correo Electrónico:</asp:Label>
    <asp:TextBox ID="txtEmail" runat="server" placeholder="Email address" CssClass="form-control" required="required"></asp:TextBox>
    <asp:RequiredFieldValidator ID="rfvEmail" runat="server" ControlToValidate="txtEmail" ErrorMessage="El correo electrónico es obligatorio." CssClass="text-danger" Display="Dynamic" />
    <asp:CustomValidator ID="cvEmailInUse" runat="server" ControlToValidate="txtEmail" ErrorMessage="El correo electrónico ya está en uso." CssClass="text-danger" Display="Dynamic" OnServerValidate="ValidateEmailInUse" />
    <asp:CustomValidator ID="cvEmail" runat="server" ControlToValidate="txtEmail" ErrorMessage="El correo electrónico debe ser una dirección válida." CssClass="text-danger" Display="Dynamic" OnServerValidate="ValidateEmailDomain" />
</div>

        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtCalle">Calle:</asp:Label>
            <asp:TextBox ID="txtCalle" runat="server" placeholder="Street Address" CssClass="form-control"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvCalle" runat="server" ControlToValidate="txtCalle" ErrorMessage="La calle es obligatoria." CssClass="text-danger" Display="Dynamic" />
        </div>
        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtLocalidad">Ciudad:</asp:Label>
            <asp:TextBox ID="txtLocalidad" runat="server" placeholder="City" CssClass="form-control"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvLocalidad" runat="server" ControlToValidate="txtLocalidad" ErrorMessage="La ciudad es obligatoria." CssClass="text-danger" Display="Dynamic" />
        </div>
        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtProvincia">Estado/Provincia:</asp:Label>
            <asp:TextBox ID="txtProvincia" runat="server" placeholder="State/Province" CssClass="form-control"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvProvincia" runat="server" ControlToValidate="txtProvincia" ErrorMessage="El estado/provincia es obligatorio." CssClass="text-danger" Display="Dynamic" />
        </div>
        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtCodigoPostal">Código Postal:</asp:Label>
            <asp:TextBox ID="txtCodigoPostal" runat="server" placeholder="Postal Code" CssClass="form-control"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvCodigoPostal" runat="server" ControlToValidate="txtCodigoPostal" ErrorMessage="El código postal es obligatorio." CssClass="text-danger" Display="Dynamic" />
            <asp:RegularExpressionValidator ID="revCodigoPostal" runat="server" ControlToValidate="txtCodigoPostal" ErrorMessage="El código postal debe ser un número de 5 dígitos." CssClass="text-danger" Display="Dynamic" ValidationExpression="^\d{5}$" />
        </div>
        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtPassword">Contraseña:</asp:Label>
            <asp:TextBox ID="txtPassword" runat="server" TextMode="Password" placeholder="Password" CssClass="form-control" required="required"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvPassword" runat="server" ControlToValidate="txtPassword" ErrorMessage="La contraseña es obligatoria." CssClass="text-danger" Display="Dynamic" />
            <asp:RegularExpressionValidator ID="revPassword" runat="server" ControlToValidate="txtPassword" ErrorMessage="La contraseña debe tener al menos 8 caracteres e incluir letras, números y símbolos." CssClass="text-danger" Display="Dynamic" ValidationExpression="^(?=.*[a-zA-Z])(?=.*\d)(?=.*\W).{8,}$" />
            <asp:Label ID="lblErrorMessage" runat="server" Text="" ForeColor="Red"></asp:Label>
        </div>
        <div class="form-group">
            <asp:Label runat="server" AssociatedControlID="txtConfirmPassword">Confirmar Contraseña:</asp:Label>
            <asp:TextBox ID="txtConfirmPassword" runat="server" TextMode="Password" placeholder="Confirm Password" CssClass="form-control" required="required"></asp:TextBox>
            <asp:RequiredFieldValidator ID="rfvConfirmPassword" runat="server" ControlToValidate="txtConfirmPassword" ErrorMessage="Confirmar contraseña es obligatorio." CssClass="text-danger" Display="Dynamic" />
            <asp:CompareValidator ID="cvPassword" runat="server" ControlToCompare="txtPassword" ControlToValidate="txtConfirmPassword" ErrorMessage="Las contraseñas no coinciden." CssClass="text-danger" Display="Dynamic" />
        </div>
        <asp:Button ID="Registrarse" runat="server" Text="CREAR" CssClass="btn btn-primary" OnClick="registrar" />
        <asp:Label ID="lblSuccessMessage" runat="server" CssClass="success-message" Visible="false"></asp:Label>
        <div class="form-footer">
            <asp:HyperLink ID="lnkLogin" runat="server" NavigateUrl="~/login.aspx">Iniciar sesión con una cuenta existente</asp:HyperLink>
            <span style="margin: 0 10px;">O</span>
            <asp:HyperLink ID="lnkReturnToStore" runat="server" NavigateUrl="~/Default.aspx">Volver a la Tienda</asp:HyperLink>
        </div>
    </div>
    <script type="text/javascript">
        function redirectToLogin() {
            setTimeout(function () {
                window.location.href = 'login.aspx';
            }, 2000);
        }
    </script>
</asp:Content>
