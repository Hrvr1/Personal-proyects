<%@ Page Title="" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="AnuncioPublicado.aspx.cs" Inherits="WebApplication.AnuncioPublicado" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <style>
        .progress-container {
            position: relative;
            width: 96%;
            height: 3px;
            background-color: #e0e0e0;
            margin-top: 20px;
            top: -4px;
            left: 5px;
        }
        .progress-bar {
            position: absolute;
            height: 100%;
            background-color: #007bff;
            transition: width 0.4s;
        }
        .step {
            position: absolute;
            top: -14px;
            width: 28px;
            height: 28px;
            background-color: #e0e0e0;
            border: 2px solid #007bff;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            color: #007bff;
            transition: background-color 0.4s, border-color 0.4s, color 0.4s;
        }
        .step.active {
            background-color: #007bff;
            color: white;
        }
    </style>

    <div class="container mt-5">
        <h2 class="text-center">Publicar Anuncio de Venta</h2>
        <asp:Label ID="lblErrorMessage" runat="server" Text="" ForeColor="Red" Visible="false"></asp:Label>
        <div class="progress-container">
            <asp:Panel ID="progressBarContainer" runat="server" CssClass="progress-bar" Style="width: 25%;"></asp:Panel>
            <asp:Label ID="step1" runat="server" CssClass="step active" Style="left: 0%;">1</asp:Label>
            <asp:Label ID="step2" runat="server" CssClass="step" Style="left: 33%;">2</asp:Label>
            <asp:Label ID="step3" runat="server" CssClass="step" Style="left: 66%;">3</asp:Label>
            <asp:Label ID="step4" runat="server" CssClass="step" Style="left: 100%;">4</asp:Label>
        </div>

        <asp:MultiView ID="MultiView1" runat="server" ActiveViewIndex="0">
            <!-- View 1: Información básica -->
            <asp:View ID="View1" runat="server">
                <div class="form-group mt-5">
                    <label for="Anio">Año de Matriculación</label>
                    <asp:TextBox ID="Anio" runat="server" CssClass="form-control"></asp:TextBox>
                    <asp:RequiredFieldValidator ID="rfvAnio" runat="server" ControlToValidate="Anio" ErrorMessage="El año es obligatorio." CssClass="text-danger" Display="Dynamic" ValidationGroup="Group1"/>
                    <asp:RangeValidator ID="rvAnio" runat="server" ControlToValidate="Anio" ErrorMessage="El año debe ser un número entre 1900 y 2024." CssClass="text-danger" MinimumValue="1900" MaximumValue="2024" Type="Integer" Display="Dynamic" />
                </div>
                <div class="form-group">
                    <label for="Marca">Marca</label>
                    <asp:TextBox ID="Marca" runat="server" CssClass="form-control"></asp:TextBox>
                    <asp:RequiredFieldValidator ID="rfvMarca" runat="server" ControlToValidate="Marca" ErrorMessage="La marca es obligatoria." CssClass="text-danger" Display="Dynamic" ValidationGroup="Group1"/>
                    <asp:RegularExpressionValidator ID="revMarca" runat="server" ControlToValidate="Marca" ErrorMessage="La marca debe tener un máximo de 45 caracteres." CssClass="text-danger" ValidationExpression="^.{1,45}$" Display="Dynamic" />
                </div>
                <div class="form-group">
                    <label for="Modelo">Modelo</label>
                    <asp:TextBox ID="Modelo" runat="server" CssClass="form-control"></asp:TextBox>
                    <asp:RequiredFieldValidator ID="rfvModelo" runat="server" ControlToValidate="Modelo" ErrorMessage="El modelo es obligatorio." CssClass="text-danger" Display="Dynamic" ValidationGroup="Group1"/>
                    <asp:RegularExpressionValidator ID="revModelo" runat="server" ControlToValidate="Modelo" ErrorMessage="El modelo debe tener un máximo de 45 caracteres." CssClass="text-danger" ValidationExpression="^.{1,45}$" Display="Dynamic" />
                </div>
                <asp:Button ID="ButtonNext1" runat="server" Text="Siguiente" CssClass="btn btn-primary" OnClick="ButtonNext1_Click" />
            </asp:View>
            <!-- View 2: Más detalles -->
            <asp:View ID="View2" runat="server">
                <div class="form-group mt-5">
                    <label for="Combustible">Combustible</label>
                    <asp:TextBox ID="Combustible" runat="server" CssClass="form-control"></asp:TextBox>
                    <asp:RequiredFieldValidator ID="rfvCombustible" runat="server" ControlToValidate="Combustible" ErrorMessage="El combustible es obligatorio." CssClass="text-danger" Display="Dynamic" ValidationGroup="Group2" />
                    <asp:RegularExpressionValidator ID="revCombustible" runat="server" ControlToValidate="Combustible" ErrorMessage="El combustible debe tener un máximo de 45 caracteres." CssClass="text-danger" ValidationExpression="^.{1,45}$" Display="Dynamic" />
                </div>
                <div class="form-group">
                    <label for="Transmision">Tipo de Transmisión</label>
                    <asp:TextBox ID="Transmision" runat="server" CssClass="form-control"></asp:TextBox>
                    <asp:RequiredFieldValidator ID="rfvTransmision" runat="server" ControlToValidate="Transmision" ErrorMessage="La transmisión es obligatoria." CssClass="text-danger" Display="Dynamic" ValidationGroup="Group2"/>
                    <asp:RegularExpressionValidator ID="revTransmision" runat="server" ControlToValidate="Transmision" ErrorMessage="La transmisión debe tener un máximo de 45 caracteres." CssClass="text-danger" ValidationExpression="^.{1,45}$" Display="Dynamic" />
                </div>
                <div class="form-group">
                    <label for="Color">Color</label>
                    <asp:TextBox ID="Color" runat="server" CssClass="form-control"></asp:TextBox>
                     <asp:RequiredFieldValidator ID="rfvColor" runat="server" ControlToValidate="Color" ErrorMessage="El color es obligatoria." CssClass="text-danger" Display="Dynamic" ValidationGroup="Group2" />
                   
                    <asp:RegularExpressionValidator ID="revColor" runat="server" ControlToValidate="Color" ErrorMessage="El color debe tener un máximo de 45 caracteres." CssClass="text-danger" ValidationExpression="^.{1,45}$" Display="Dynamic" />
                </div>
                <div class="form-group">
                    <label for="Kilometros">Kilómetros (km)</label>
                    <asp:TextBox ID="Kilometros" runat="server" CssClass="form-control"></asp:TextBox>
                    <asp:RequiredFieldValidator ID="rfvKilometros" runat="server" ControlToValidate="Kilometros" ErrorMessage="Los kilómetros son obligatorios." CssClass="text-danger" Display="Dynamic" ValidationGroup="Group2" />
                    <asp:RegularExpressionValidator ID="revKilometros" runat="server" ControlToValidate="Kilometros" ErrorMessage="Los kilómetros deben ser un número entero." CssClass="text-danger" ValidationExpression="^\d+$" Display="Dynamic" ValidationGroup="Group2"/>
                </div>
                <asp:Button ID="ButtonPrevious1" runat="server" Text="Anterior" CssClass="btn btn-secondary" OnClick="ButtonPrevious1_Click" />
                <asp:Button ID="ButtonNext2" runat="server" Text="Siguiente" CssClass="btn btn-primary" OnClick="ButtonNext2_Click" />
            </asp:View>
            <!-- View 3: Información adicional -->
            <asp:View ID="View3" runat="server">
                <div class="form-group mt-5">
    <label for="Precio">Precio (€)</label>
    <asp:TextBox ID="Precio" runat="server" CssClass="form-control"></asp:TextBox>
    <asp:RequiredFieldValidator ID="rfvPrecio" runat="server" ControlToValidate="Precio" ErrorMessage="El precio es obligatorio." CssClass="text-danger" Display="Dynamic" ValidationGroup="Group3"/>
    <asp:RegularExpressionValidator ID="revPrecio" runat="server" ControlToValidate="Precio" ErrorMessage="El precio debe ser un número decimal." CssClass="text-danger" ValidationExpression="^\d+([.,]\d{1,2})?$" Display="Dynamic" ValidationGroup="Group3"/>
</div>

                <div class="form-group">
                    <label for="InformacionAdicional">Añade más información a tu anuncio</label>
                    <asp:TextBox ID="InformacionAdicional" runat="server" TextMode="MultiLine" CssClass="form-control"></asp:TextBox>
                    <asp:RequiredFieldValidator ID="rfvInformacionAdicional" runat="server" ControlToValidate="InformacionAdicional" ErrorMessage="La información adicional es obligatoria." CssClass="text-danger" Display="Dynamic" ValidationGroup="Group3"/>
                    <asp:RegularExpressionValidator ID="revInformacionAdicional" runat="server" ControlToValidate="InformacionAdicional" ErrorMessage="La descripción debe tener un máximo de 200 caracteres." CssClass="text-danger" ValidationExpression="^.{1,200}$" Display="Dynamic" />
                </div>
                <asp:Button ID="ButtonPrevious2" runat="server" Text="Anterior" CssClass="btn btn-secondary" OnClick="ButtonPrevious2_Click" />
                <asp:Button ID="ButtonNext3" runat="server" Text="Siguiente" CssClass="btn btn-primary" OnClick="ButtonNext3_Click" />
            </asp:View>
            <!-- View 4: Foto -->
            <asp:View ID="View4" runat="server">
                <div class="form-group mt-5">
                    <label for="FotoVehiculo">Sube una Foto del Vehículo</label>
                    <asp:FileUpload ID="FotoVehiculo" runat="server" CssClass="form-control" />
                    <asp:RequiredFieldValidator ID="rfvFotoVehiculo" runat="server" ControlToValidate="FotoVehiculo" ErrorMessage="La foto del vehículo es obligatoria." CssClass="text-danger" Display="Dynamic" InitialValue="" />
                </div>
                <asp:Button ID="ButtonPrevious3" runat="server" Text="Anterior" CssClass="btn btn-secondary" OnClick="ButtonPrevious3_Click" />
                <asp:Button ID="ButtonSubmit" runat="server" Text="Publicar Anuncio" CssClass="btn btn-success" OnClick="ButtonSubmit_Click" />
            </asp:View>
        </asp:MultiView>
    </div>
</asp:Content>
