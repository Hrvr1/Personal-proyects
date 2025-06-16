using System;
using System.Data;
using System.Web.UI;
using System.Web.UI.WebControls;
using Library;

namespace WebApplication
{
    public partial class Catalogo : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                CargarMarcas();
                MostrarTodosLosVehiculos();
            }
        }

        protected void btnApplyFilters_Click(object sender, EventArgs e)
        {
            FiltrarVehiculos();
        }

        private void MostrarTodosLosVehiculos()
        {
            try
            {
                CADVehiculo cadCatalogo = new CADVehiculo();
                DataTable resultados = cadCatalogo.ObtenerTodosLosVehiculos();
                MostrarResultados(resultados);
            }
            catch (Exception ex)
            {

                Console.WriteLine("Error al mostrar todos los vehículos: " + ex.Message);
            }
        }

        private void FiltrarVehiculos()
        {
            try
            {
                int marcaId = 0;
                if (!string.IsNullOrEmpty(ddlMarca.SelectedValue))
                {
                    int.TryParse(ddlMarca.SelectedValue, out marcaId);
                }

                string modelo = txtModelo.Text;
                string transmision = ddlTransmision.SelectedValue;
                string combustible = ddlCombustible.SelectedValue;

                string precioMin = Request.Form["priceRangeMin"];
                string precioMax = Request.Form["priceRangeMax"];
                string kilometrajeMin = Request.Form["kmRangeMin"];
                string kilometrajeMax = Request.Form["kmRangeMax"];

                string anyoMin = txtAnyoMin.Text;

                CADVehiculo cadCatalogo = new CADVehiculo();
                DataTable resultados = cadCatalogo.ObtenerVehiculosFiltrados(
                    marcaId, modelo, transmision, combustible,
                    precioMin, precioMax, kilometrajeMin, kilometrajeMax, anyoMin
                );
                MostrarResultados(resultados);
            }
            catch (Exception ex)
            {

                Console.WriteLine("Error al filtrar los vehículos: " + ex.Message);
            }
        }

        private void MostrarResultados(DataTable resultados)
        {
            try
            {
                resultsRepeater.DataSource = resultados;
                resultsRepeater.DataBind();

                foreach (RepeaterItem item in resultsRepeater.Items)
                {
                    Button btnFavoritos = (Button)item.FindControl("btnFavoritos");
                    Button btnCarrito = (Button)item.FindControl("btnCarrito");
                    Button btnCompra = (Button)item.FindControl("btnCompra");

                    bool vendido = Convert.ToBoolean(DataBinder.Eval(item.DataItem, "vendido"));

                    if (vendido)
                    {
                        btnFavoritos.Enabled = false;
                        btnCarrito.Enabled = false;
                        btnCompra.Enabled = false;
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al mostrar los resultados: " + ex.Message);
            }
        }

        private void CargarMarcas()
        {
            try
            {
                CADMarcas cadMarcas = new CADMarcas();
                DataTable marcas = cadMarcas.ObtenerMarcasDesdeBaseDeDatos();

                ddlMarca.Items.Clear();
                ddlMarca.Items.Add(new ListItem("-- Seleccione una marca --", ""));

                foreach (DataRow row in marcas.Rows)
                {
                    string marcaNombre = row["marca"].ToString();
                    string marcaId = row["marca_id"].ToString();
                    ddlMarca.Items.Add(new ListItem(marcaNombre, marcaId));
                }
            }
            catch (Exception ex)
            {

                Console.WriteLine("Error al cargar las marcas: " + ex.Message);
            }
        }

        protected void AccionVehiculo_Click(object sender, EventArgs e)
        {
            if (Session["usuarios"] == null)
            {
                Response.Redirect("login.aspx");
                return;
            }

            Button btn = (Button)sender;
            int vehiculoId = Convert.ToInt32(btn.CommandArgument);

            CADVehiculo cadCatalogo = new CADVehiculo();
            ENVehiculo vehiculo = cadCatalogo.ReadVehiculo(vehiculoId);

            ENUsuario user = (ENUsuario)Session["usuarios"];
            string username = user.Username;

            if (vehiculo.Vendido == 1)
            {
                ScriptManager.RegisterStartupScript(this, GetType(), "showalert", "alert('No está permitida esta acción porque este vehículo está vendido.');", true);
                return;
            }
            try
            {
                ENCarrito encarrito = new ENCarrito(username);
                ENListaFavorito enlistafavorito = new ENListaFavorito(username);

                if (btn.CommandName == "Favoritos")
                {
                    enlistafavorito.AddFavoriteCar(vehiculoId);
                }
                else if (btn.CommandName == "Carrito")
                {
                   encarrito.addNewUser();

                   encarrito.add(vehiculoId);
                }
                else if (btn.CommandName == "Compra")
                {
                    Response.Redirect($"Pedido.aspx?vehiculoId={vehiculoId}");
                }
            }
            catch (Exception ex)
            {

                Console.WriteLine("Error en la acción del vehículo: " + ex.Message);
            }
        }
    }
}
