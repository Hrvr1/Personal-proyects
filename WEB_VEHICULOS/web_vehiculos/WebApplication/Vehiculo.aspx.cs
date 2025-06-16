using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Text;
using Library;
using Library.EN;

namespace WebApplication
{
    public partial class Vehiculo : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                // Verificar si se ha proporcionado un vehiculo_id en la consulta
                if (Request.QueryString["id"] != null)
                {
                    int vehiculoId = Convert.ToInt32(Request.QueryString["id"]);

                    // Obtener los detalles del vehículo usando el vehiculo_id proporcionado
                    CADVehiculo cADVehiculo = new CADVehiculo();
                    ENVehiculo envehiculo = cADVehiculo.ReadVehiculo(vehiculoId);

                    // Mostrar los detalles del vehículo en la página
                    MostrarDetallesVehiculo(envehiculo);

                    // Muestra estrellas en funcion de la valoración
                    MostrarValoracion(envehiculo);

                    lblVendido.Visible = (envehiculo.Vendido == 1);

                    //muetra comentarios
                    CargarComentarios(vehiculoId);
                }
                else
                {
                    // Si no se proporciona un vehiculo_id, mostrar un mensaje de error o redirigir a otra página
                    Response.Redirect("Error.aspx");
                }
            }
        }

        // Método para mostrar los detalles del vehículo en la página
        private void MostrarDetallesVehiculo(ENVehiculo vehiculo)
        {
            if (vehiculo != null)
            {
                // Mostrar el modelo del vehículo
                LiteralModelo.Text = $"{vehiculo.Modelo}";

                // Mostrar la marca del vehículo
                CADMarcas cADMarcas = new CADMarcas();
                LiteralMarca.Text = $"{cADMarcas.ObtenerMarca(vehiculo.Marca_id)}";

                //Mostra la marca y el modelo
                LiteralMarcaModelo.Text = $"{vehiculo.Modelo}" + " " + $"{cADMarcas.ObtenerMarca(vehiculo.Marca_id)}";

                // Mostrar si es automático o manual
                LiteralAuto.Text = $"{vehiculo.Auto_Manu}";

                // Mostrar el kilometraje del vehículo
                LiteralKilometraje.Text = $"{vehiculo.Kilometraje}" + " Km";

                // Mostrar el color del vehículo
                LiteralColor.Text = $"{vehiculo.Color}";

                // Mostrar el precio del vehículo
                LiteralPrecio.Text = $"{vehiculo.Precio}" + "€";

                //Mostrar el año del vehiculo
                LiteralAnyo.Text = $"{vehiculo.Anyo}";

                //Mostrar el tipo de combustible
                LiteralCombustible.Text = $"{vehiculo.Combustible}";

                //Mostrar La descripcion
                LiteralDescripcion.Text = $"{vehiculo.Descripcion}";

                // Mostrar la imagen del vehículo
                ImageVehiculo.ImageUrl = vehiculo.Url_imagen;
            }
            else
            {
                // Si no se encuentra el vehículo, mostrar un mensaje de error o redirigir a otra página
                Response.Redirect("Error.aspx");
            }
        }

        private void MostrarValoracion(ENVehiculo vehiculo)
        {
            if (vehiculo != null)
            {
                LiteralValoracion.Text = vehiculo.Valoracion.ToString("0.0");
                LiteralStars.Text = GenerarEstrellas(vehiculo.Valoracion);
              
            }
            else
            {
                Response.Redirect("Error.aspx");
            }
        }

        private string GenerarEstrellas(decimal valoracion)
        {
            int estrellasCompletas = (int)valoracion;
            string estrellasHtml = new string('★', estrellasCompletas);
            string estrellasVacias = new string('☆', 5 - estrellasCompletas);
            return estrellasHtml + estrellasVacias;
        }


        protected void AccionVehiculo_Click(object sender, EventArgs e)
        {
            if (Session["usuarios"] == null)
            {
                Response.Redirect("login.aspx");
                return;
            }

            Button btn = (Button)sender;
            int vehiculoId = Convert.ToInt32(Request.QueryString["id"]);

            ENUsuario user = (ENUsuario)Session["usuarios"];
            string username = user.Username;

            CADVehiculo cadCatalogo = new CADVehiculo();
            ENVehiculo vehiculo = cadCatalogo.ReadVehiculo(vehiculoId);

            CADCarrito cadCarrito = new CADCarrito();
            CADListaFavorito cadLineaFavorito = new CADListaFavorito();

            if (vehiculo.Vendido == 1)
            {
                ScriptManager.RegisterStartupScript(this, GetType(), "showalert", "alert('No está permitida esta acción porque este vehículo está vendido.');", true);
                return;
            }
            else
            {
                if (btn.CommandName == "Favoritos")
                {
                    // Añadir a favoritos
                    cadLineaFavorito.AddFavoriteCar(username, vehiculoId);
                }
                else if (btn.CommandName == "Carrito")
                {
                    // Añadir a carrito
                    cadCarrito.AddCarrito(username, vehiculoId);
                }
                else if (btn.CommandName == "Compra")
                {
                    // Redirigir a la página de compra
                    Response.Redirect($"Payments.aspx?vehiculoId={vehiculoId}");
                }
            }

        }

        private void CargarComentarios(int vehiculoId)
        {
            CADComentario cadComentario = new CADComentario();
            List<ENComentario> comentarios = cadComentario.GetComentarios(vehiculoId: vehiculoId);
            RepeaterComentarios.DataSource = comentarios;
            RepeaterComentarios.DataBind();
        }
        protected bool IsVisible(string type, string username)
        {
            if (Session["usuarios"] != null)
            {
                ENUsuario usuario = (ENUsuario)Session["usuarios"];
                if (usuario.Admin || usuario.Username == username)
                {
                    return type == "Edit" || type == "Delete";
                }
            }
            return false;
        }
        protected void ButtonAgregarComentario_Click(object sender, EventArgs e)
        {
            if (Session["usuarios"] != null)
            {
                ENUsuario usuario = (ENUsuario)Session["usuarios"];
                int vehiculoId = Convert.ToInt32(Request.QueryString["id"]);
                string comentarioTexto = TextBoxComentario.Text;
                DateTime fechaComentario = DateTime.Now;

                ENComentario nuevoComentario = new ENComentario(0, vehiculoId, usuario.Username, comentarioTexto, fechaComentario);
                CADComentario cadComentario = new CADComentario();
                cadComentario.AddComentario(nuevoComentario);

                // Obtener información del vehículo
                CADVehiculo cadVehiculo = new CADVehiculo();
                ENVehiculo vehiculo = cadVehiculo.ReadVehiculo(vehiculoId);
                string vendedorUName = vehiculo.Vendedor_UName;

                // Agregar notificación de comentario
                CADBandejaNotificacion cadBandejaNotificacion = new CADBandejaNotificacion();
                ENBandejaNotificacion nuevaNotificacion = new ENBandejaNotificacion();
                nuevaNotificacion.UsuarioUName = vendedorUName;

                ENLineaBandejaNotificacion nuevaLineaNotificacion = new ENLineaBandejaNotificacion();
                nuevaLineaNotificacion.VehiculoID = vehiculoId;
                nuevaLineaNotificacion.TipoNotificacion = "Comentario";
                nuevaLineaNotificacion.FechaNotificacion = fechaComentario;

                cadBandejaNotificacion.AgregarBandejaNotificacion(nuevaNotificacion, nuevaLineaNotificacion);

                CargarComentarios(vehiculoId);
                TextBoxComentario.Text = string.Empty;

                decimal nuevaValoracion = ObtenerValoracionSeleccionada();
                ActualizarValoracion(vehiculoId, nuevaValoracion);
            }
            else
            {
                // Redirigir al usuario a la página de inicio de sesión si no está iniciado sesión
                Response.Redirect("login.aspx");
            }
        }


        /*..*/
        private decimal ObtenerValoracionSeleccionada()
        {
            decimal valoracion = 0;
            if (Request.Form["rating"] != null)
            {
                decimal.TryParse(Request.Form["rating"], out valoracion);
            }
            return valoracion;
        }

        private void ActualizarValoracion(int vehiculoId, decimal nuevaValoracion)
        {
            if (nuevaValoracion > 0)
            {
                CADVehiculo cadVehiculo = new CADVehiculo();
                ENVehiculo vehiculo = cadVehiculo.ReadVehiculo(vehiculoId);

                int totalValoraciones = cadVehiculo.ObtenerTotalValoraciones(vehiculoId);
                decimal valoracionActual = vehiculo.Valoracion;
                decimal valoracionPromedio = ((valoracionActual * totalValoraciones) + nuevaValoracion) / (totalValoraciones + 1);

                vehiculo.Valoracion = valoracionPromedio;
                cadVehiculo.UpdateVehiculo(vehiculo);
            }
        }

        protected void ButtonEditar_Click(object sender, EventArgs e)
        {
            Button btn = (Button)sender;
            RepeaterItem item = (RepeaterItem)btn.NamingContainer;


            Label labelComentario = (Label)item.FindControl("LabelComentario");
            TextBox textBoxEditComentario = (TextBox)item.FindControl("TextBoxEditComentario");
            Button buttonGuardar = (Button)item.FindControl("ButtonGuardar");
            Button buttonEditar = (Button)item.FindControl("ButtonEditar");

            labelComentario.Visible = false;
            textBoxEditComentario.Visible = true;
            buttonGuardar.Visible = true;
            buttonEditar.Visible = false;
        }
        protected void ButtonGuardar_Click(object sender, EventArgs e)
        {
            Button btn = (Button)sender;
            int comentarioId = int.Parse(btn.CommandArgument);
            RepeaterItem item = (RepeaterItem)btn.NamingContainer;

            TextBox textBoxEditComentario = (TextBox)item.FindControl("TextBoxEditComentario");
            string comentarioTexto = textBoxEditComentario.Text;

            ENUsuario usuario = (ENUsuario)Session["usuarios"];
            int vehiculoId = Convert.ToInt32(Request.QueryString["id"]);
            ENComentario comentarioEditado = new ENComentario(comentarioId, vehiculoId, usuario.Username, comentarioTexto, DateTime.Now);
            CADComentario cadComentario = new CADComentario();
            cadComentario.UpdateComentario(comentarioEditado);

            CargarComentarios(vehiculoId);
        }
        protected void ButtonEliminar_Click(object sender, EventArgs e)
        {
            Button btn = (Button)sender;
            int comentarioId = int.Parse(btn.CommandArgument);
            CADComentario cadComentario = new CADComentario();

            if (Session["usuarios"] != null)
            {
                ENUsuario usuario = (ENUsuario)Session["usuarios"];
                ENComentario comentario = cadComentario.GetComentarios(comentarioId: comentarioId).FirstOrDefault();

                if (comentario.UsuarioUName == usuario.Username || usuario.Admin)
                {
                    cadComentario.DeleteComentario(comentarioId);
                    int vehiculoId = Convert.ToInt32(Request.QueryString["id"]);
                    CargarComentarios(vehiculoId);
                }
            }
        }
        protected bool IsEditButtonVisible(string comentarioUsername)
        {
            if (Session["usuarios"] != null)
            {
                ENUsuario usuario = (ENUsuario)Session["usuarios"];
                return usuario.Username == comentarioUsername;
            }
            return false;
        }
        protected bool IsDeleteButtonVisible(string comentarioUsername)
        {
            if (Session["usuarios"] != null)
            {
                ENUsuario usuario = (ENUsuario)Session["usuarios"];
                return usuario.Username == comentarioUsername || usuario.Admin;
            }
            return false;
        }

        protected void SubmitRating_Click(object sender, EventArgs e)
        {
            if (Session["usuarios"] != null && ddlRating.SelectedValue != null)
            {
                int rating = Convert.ToInt32(ddlRating.SelectedValue);
                int vehiculoId = Convert.ToInt32(Request.QueryString["id"]);
                ActualizarValoracionEnBaseDeDatos(vehiculoId, rating);
                Response.Redirect(Request.Url.AbsoluteUri); // Recargar la página para mostrar la nueva valoración
            }
            else
            {
                Response.Redirect("login.aspx");
            }
        }

        private void ActualizarValoracionEnBaseDeDatos(int vehiculoId, int valoracion)
        {
            var cadVehiculo = new CADVehiculo();
            if (!cadVehiculo.ActualizarValoracion(vehiculoId, valoracion))
            {
                throw new Exception("No se pudo actualizar la valoración del vehículo.");
            }
        }

    }
}

