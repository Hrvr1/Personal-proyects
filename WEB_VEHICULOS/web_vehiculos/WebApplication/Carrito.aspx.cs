using Library;
using System;
using System.Data;
using System.Web.UI.WebControls;

namespace WebApplication
{
    public partial class Carrito : System.Web.UI.Page
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
                    BindCartItems();
                }
            }
        }

        protected void Repeater_ItemCommand(object source, RepeaterCommandEventArgs e)
        {
            try
            {
                if (e.CommandName == "EliminarVehiculo")
                {
                    int lineaCarritoId = Convert.ToInt32(e.CommandArgument);
                    DeleteCartItem(lineaCarritoId);
                    BindCartItems();
                }
                else if (e.CommandName == "VerVehiculo")
                {
                    int vehiculoId = Convert.ToInt32(e.CommandArgument);
                    Response.Redirect($"~/Vehiculo.aspx?id={vehiculoId}");
                } 
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al utilizar los botones: " + ex.Message);
            }
        }

        protected void BindCartItems()
        {
            try
            {
                ENUsuario enusuario = (ENUsuario)Session["usuarios"];
                string usuario = enusuario.Username;
                ENCarrito encarrito = new ENCarrito(usuario);

                if (!encarrito.checkUser())
                {
                    encarrito.addNewUser();
                }

                DataSet cartItems = encarrito.show();

                if (cartItems.Tables.Count > 0 && cartItems.Tables[0].Rows.Count > 0)
                {
                    carritoRepeater.DataSource = cartItems.Tables[0];
                    carritoRepeater.DataBind();

                    lblTotalPrice.Text = "Precio total: " + encarrito.precioTotal().ToString() + "€";
                }
                else
                {
                    carritoRepeater.DataSource = null;
                    carritoRepeater.DataBind();
                    SinCarrito.Visible = true;
                    TablaComprar.Visible = false;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al mostrar carrito: " + ex.Message);
            }
        }

        protected void DeleteCartItem(int lineaCarritoId)
        {
            try
            {
                ENLineaCarrito enlineaCarrito = new ENLineaCarrito();
                enlineaCarrito.EliminarLineaCarritoPorId(lineaCarritoId);
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al eliminar elemento del carrito: " + ex.Message);
            }
        }

        protected void Comprar(Object sender, EventArgs e)
        {
            Response.Redirect("~/Pedido.aspx");
        }

        protected void VaciarTodo(Object sender, EventArgs e)
        {
            try{
                ENUsuario enusuario = (ENUsuario)Session["usuarios"];
                string usuario = enusuario.Username;

                ENCarrito encarrito = new ENCarrito(usuario);

                encarrito.deleteAll();
                BindCartItems();
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al eliminar todo del carrito: " + ex.Message);
            }
        }

        protected void IrCatalogo(Object sender, EventArgs e)
        {
            Response.Redirect("~/Catalogo.aspx");
        }
    }
}
