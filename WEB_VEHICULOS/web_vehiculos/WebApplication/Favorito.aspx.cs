using System;
using System.Data;
using System.Web.UI.WebControls;
using Library;

namespace WebApplication
{
    public partial class Favorito : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                if (Session["usuarios"] == null)
                {
                    Response.Redirect("login.aspx");
                }
                else
                {
                    BindFavoritos();
                }
            }
        }

        protected void Repeater_ItemCommand(object source, RepeaterCommandEventArgs e)
        {
            try
            {
                if (e.CommandName == "EliminarFavorito")
                {
                    int favoritoId = Convert.ToInt32(e.CommandArgument);
                    DeleteFavorito(favoritoId);
                    BindFavoritos();
                }
                else if (e.CommandName == "VerVehiculo")
                {
                    int vehiculoId = Convert.ToInt32(e.CommandArgument);
                    Response.Redirect($"~/Vehiculo.aspx?id={vehiculoId}");
                }
                else if (e.CommandName == "AddCarrito")
                {
                    int vehiculoId = Convert.ToInt32(e.CommandArgument);
                    ENCarrito enCarrito = new ENCarrito();
                    ENUsuario enusuario = (ENUsuario)Session["usuarios"];
                    string usuario = enusuario.Username;

                    enCarrito.Usuario_name = usuario;
                    enCarrito.add(vehiculoId);
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error in Repeater_ItemCommand: " + ex.Message);
            }
        }

        protected void BindFavoritos()
        {
            try
            {
                CADListaFavorito cadFavorito = new CADListaFavorito();
                ENUsuario enusuario = (ENUsuario)Session["usuarios"];
                string usuario = enusuario.Username;

                DataSet favoritoItems = cadFavorito.Show(usuario);

                if (favoritoItems.Tables.Count > 0 && favoritoItems.Tables[0].Rows.Count > 0)
                {
                    favoritoRepeater.DataSource = favoritoItems.Tables[0];
                    favoritoRepeater.DataBind();
                }
                else
                {
                    favoritoRepeater.DataSource = null;
                    favoritoRepeater.DataBind();
                    SinFavorito.Visible = true;
                    TablaOpciones.Visible = false;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al mostrar favoritos: " + ex.Message);
            }
        }

        protected void DeleteFavorito(int favoritoId)
        {
            try
            {
                ENUsuario enusuario = (ENUsuario)Session["usuarios"];
                string usuario = enusuario.Username;
                ENListaFavorito enlistafavorito = new ENListaFavorito(usuario);

                enlistafavorito.RemoveFavoriteCar(favoritoId);
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al eliminar favorito: " + ex.Message);
            }
        }

        protected void VaciarFavoritoTodo(object sender, EventArgs e)
        {
            try
            {
                ENUsuario enusuario = (ENUsuario)Session["usuarios"];
                string usuario = enusuario.Username;

                ENListaFavorito enlistafavorito = new ENListaFavorito(usuario);

                enlistafavorito.deleteAll();
                BindFavoritos();
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al eliminar todo del carrito: " + ex.Message);
            }
        }

        protected void IrCatalogo(object sender, EventArgs e)
        {
            Response.Redirect("Catalogo.aspx");
        }
    }
}
