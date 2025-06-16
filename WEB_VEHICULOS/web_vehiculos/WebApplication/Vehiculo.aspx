<%@ Page Title="Vehiculo" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Vehiculo.aspx.cs" Inherits="WebApplication.Vehiculo" %>

<asp:Content ID="Content1" ContentPlaceHolderID="MainContent" runat="server">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #343a40;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        gap: 20px;
        flex-direction: column;
    }
    .details-container {
        flex: 2;
        margin-right: 340px; /* espacio para el sello de calidad */
    }
    .grid-container {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 10px 20px;
        margin-top: 20px;
        align-items: center;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 10px;
        padding: 20px;
    }
    h2 {
        text-align: center;
        color: #007bff;
        font-size: 1.8em;
        margin-bottom: 20px;
    }
    h3 {
        margin: 0;
        font-size: 1.1em;
        color: #495057;
    }
    .message {
        color: green;
        font-weight: bold;
    }
    .image-container {
        position: relative;
        display: inline-block;
    }
    .vehicle-image {
        max-width: 100%;
        border-radius: 10px;
        border: 1px solid #ced4da;
    }
    .button-container {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-bottom: 20px;
        margin-top: 20px;
    }
    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
        transition: background-color 0.3s ease;
    }
    .btn-favoritos {
        background-color: #ffcccb;
        color: red;
    }
    .btn-favoritos:hover {
        background-color: #ffb3b0;
    }
    .btn-carrito {
        background-color: #add8e6;
        color: #007bff;
    }
    .btn-carrito:hover {
        background-color: #94c6d6;
    }
    .btn-compra {
        background-color: #90ee90;
        color: darkblue;
    }
    .btn-compra:hover {
        background-color: #7cd67c;
    }
    .sello-calidad {
        background-color: #f0f8ff;
        border: 1px solid #d0e0f0;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
        position: fixed;
        top: 120px;
        right: 20px;
        width: 300px;
        max-height: 80vh;
        overflow-y: auto;
    }
    .sello-calidad h3 {
        color: #007bff;
        font-size: 1.4em;
        margin-bottom: 10px;
    }
    .sello-calidad ul {
        list-style-type: none;
        padding: 0;
    }
    .sello-calidad ul li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    .sello-calidad ul li::before {
        content: "✔";
        color: green;
        margin-right: 10px;
        font-size: 1.2em;
    }
        }
    .comment-section {
        margin-top: 40px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .comment-section h2 {
        color: #007bff;
        font-size: 1.5em;
        margin-bottom: 20px;
    }
    .comment-box {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        margin-bottom: 10px;
    }
    .comment-list {
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        border-top: 1px solid #dee2e6;
    }
    .comment {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        margin-bottom: 10px;
    }
    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    .comment-author {
        font-weight: bold;
        color: #343a40;
    }
    .comment-date {
        font-size: 0.8em;
        color: #6c757d;
    }
    .comment-body {
        margin-bottom: 5px;
        color: #495057;
    }
    .comment-actions {
        display: flex;
        gap: 5px;
    }
    .comment-actions .btn {
        padding: 5px 10px;
        font-size: 0.8em;
    }

    .vendido-label {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        writing-mode: vertical-rl;
        background-color: red;
        padding: 10px;
        color: white; 
        font-weight: bold;
        font-size: 22px; 
        line-height: 20px;
    }

    </style>

    <div class="container">
        <div class="details-container">
            <h2>
                <asp:Literal ID ="LiteralMarcaModelo" runat ="server"></asp:Literal>
            </h2>
            <div class="image-container">
                <asp:Image ID="ImageVehiculo" runat="server" CssClass="vehicle-image" />
                <asp:Label ID="lblVendido" runat="server" Text="Vendido" Visible='<%# Convert.ToBoolean(Eval("vendido")) %>' CssClass="vendido-label"></asp:Label>
            </div>
            <div class="button-container">
                <asp:Button ID="btnFavoritos" runat="server" Text="❤ Añadir a Favoritos" CommandName="Favoritos" CommandArgument='<%# Eval("vehiculo_id") %>' OnClick="AccionVehiculo_Click" CssClass="btn btn-favoritos" />
                <asp:Button ID="btnCarrito" runat="server" Text="🛒 Añadir a Carrito" CommandName="Carrito" CommandArgument='<%# Eval("vehiculo_id") %>' OnClick="AccionVehiculo_Click" CssClass="btn btn-carrito" />
                <asp:Button ID="btnCompra" runat="server" Text="💶 Compra Ya" CommandName="Compra" CommandArgument='<%# Eval("vehiculo_id") %>' OnClick="AccionVehiculo_Click" CssClass="btn btn-compra" />
            </div>
            <asp:Label ID="lblMessage" runat="server" CssClass="message" Visible="false" />
            <div class="grid-container">

                <h3>Marca:</h3>
                <asp:Literal ID="LiteralMarca" runat="server"></asp:Literal>

                <h3>Modelo:</h3>
                <asp:Literal ID="LiteralModelo" runat="server"></asp:Literal>
            
                <h3>Color:</h3>
                <asp:Literal ID="LiteralColor" runat="server"></asp:Literal>
                
                <h3>Precio:</h3>
                <asp:Literal ID="LiteralPrecio" runat="server"></asp:Literal>

                <h3>Año de fabricación:</h3>
                <asp:Literal ID="LiteralAnyo" runat="server"></asp:Literal>

                <h3>Kilometraje:</h3>
                <asp:Literal ID="LiteralKilometraje" runat="server"></asp:Literal>
                
                <h3>Transmisión:</h3>
                <asp:Literal ID="LiteralAuto" runat="server"></asp:Literal>

                <h3>Combustible:</h3>
                <asp:Literal ID="LiteralCombustible" runat="server"></asp:Literal>

                <h3>Descripción: </h3>
                <asp:Literal ID="LiteralDescripcion" runat="server"></asp:Literal>
                 <h3>Valoración:</h3>
                <asp:Literal ID="LiteralValoracion" runat="server"></asp:Literal>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <asp:Literal ID="Literal1" runat="server"></asp:Literal>
<asp:Literal ID="LiteralStars" runat="server"></asp:Literal>



                <br />
                 <h3>&nbsp;</h3>
                <div class="rating">



 </div>
                <br />
            </div>
            <br /><br />

            <div class="comment-section">
                <h2>Comentarios</h2>
                               
               
        <asp:Label ID="lblRating" runat="server" Text="Valoración: "></asp:Label>
              <asp:DropDownList ID="ddlRating" runat="server">
                  <asp:ListItem Value="0">0</asp:ListItem>
                  <asp:ListItem Value="1">1</asp:ListItem>
                  <asp:ListItem Value="2">2</asp:ListItem>
                  <asp:ListItem Value="3">3</asp:ListItem>
                  <asp:ListItem Value="4">4</asp:ListItem>
                  <asp:ListItem Value="5">5</asp:ListItem>
              </asp:DropDownList>
              <asp:Button ID="ButtonEnviarValoracion" runat="server" Text="Enviar Valoración" OnClick="SubmitRating_Click" CssClass="btn btn-primary" Visible='<%# Session["usuarios"] != null %>' />


            
                <br />
                <br />


            
                <asp:TextBox ID="TextBoxComentario" runat="server" CssClass="comment-box" TextMode="MultiLine" Rows="3" placeholder="Escribe tu comentario aquí..."></asp:TextBox><br />
                
 


                <asp:Button ID="ButtonAgregarComentario" runat="server" Text="Agregar Comentario" OnClick="ButtonAgregarComentario_Click" CssClass="btn btn-primary" Visible='<%# Session["usuarios"] != null %>' />

                <div class="comment-list">
                    <asp:Repeater ID="RepeaterComentarios" runat="server">
                        <ItemTemplate>
                            <div class="comment">
                                <div class="comment-header">
                                    <span class="comment-author"><%# Eval("UsuarioUName") %>:</span>
                                    <span class="comment-date"><%# Eval("FechaComentario") %></span>
                                </div>
                                <div class="comment-body">
                                    <asp:Label ID="LabelComentario" runat="server" Text='<%# Eval("Comentario") %>'></asp:Label>
                                    <asp:TextBox ID="TextBoxEditComentario" runat="server" Text='<%# Eval("Comentario") %>' Visible="false" CssClass="comment-box"></asp:TextBox>
                                </div>
                                <div class="comment-actions">
                                    <asp:Button ID="ButtonEditar" runat="server" Text="Editar" CommandArgument='<%# Eval("ComentarioId") %>' OnClick="ButtonEditar_Click" CssClass="btn btn-secondary" Visible='<%# IsEditButtonVisible(Eval("UsuarioUName").ToString()) %>' />
                                    <asp:Button ID="ButtonGuardar" runat="server" Text="Guardar" CommandArgument='<%# Eval("ComentarioId") %>' OnClick="ButtonGuardar_Click" CssClass="btn btn-success" Visible="false" />
                                    <asp:Button ID="ButtonEliminar" runat="server" Text="Eliminar" CommandArgument='<%# Eval("ComentarioId") %>' OnClick="ButtonEliminar_Click" CssClass="btn btn-danger" Visible='<%# IsDeleteButtonVisible(Eval("UsuarioUName").ToString()) %>' />
                                </div>
                            </div>
                        </ItemTemplate>
                    </asp:Repeater>
                    <br />
                </div>
            </div>
        </div>

        <div class="sello-calidad">
            <h3>Sello de Calidad</h3>
            <ul>
                <li>Garantía Calidad OnlyCars</li>
                <li>Coches de “buena mano”</li>
                <li>Kilometraje garantizado</li>
                <li>Mejor precio garantizado</li>
                <li>Limpieza y lavado profesional</li>
                <li>Revisión certificada de 320 puntos</li>
                <li>Sin daños estructurales y libre de cargas</li>
                <li>Mecánica garantizada y revisada 360º</li>
            </ul>
        </div>

    </div>

</asp:Content>
