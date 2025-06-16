using System;
using System.Collections.Generic;
using System.Data;
using System.Net;
using System.Net.Mail;
using Library;

namespace WebApplication
{
    public partial class Pedido : System.Web.UI.Page
    {
        private CADPedido cadPedido = new CADPedido();


        protected void Page_Load(object sender, EventArgs e)
        {
            int? idVehiculo;

            if (Session["usuarios"] == null)
            {
                Response.Redirect("login.aspx");
                return;
            }
            if (!IsPostBack)
            {
                if (Request.QueryString["vehiculoId"] == null)
                {
                    idVehiculo = null;
                }
                else
                {
                    idVehiculo = Convert.ToInt32(Request.QueryString["vehiculoId"]);
                }
                CargarPedido(idVehiculo);
            }
        }

        private void CargarPedido(int? idVehiculo)
        {
            DataSet vehiculos;
            if (idVehiculo != null)
            {
                vehiculos = cadPedido.ObtenerByIdVehiculo(idVehiculo.Value);
            }
            else
            {
                ENUsuario enusuario = (ENUsuario)Session["usuarios"];
                vehiculos = cadPedido.ObtenerByCarritoCompra(enusuario.username);
            }

            if (vehiculos == null || vehiculos.Tables.Count == 0)
            {
                lblMensaje.Text = "No se ha encontrado el vehiculo";
                return;
            }

            lineapedidoRepeater.DataSource = vehiculos;
            lineapedidoRepeater.DataBind();
            decimal total = 0;
            foreach (DataRow vehiculo in vehiculos.Tables[0].Rows)
            {
                total += (decimal)vehiculo["precio"];
            }

            lblTotal.Text = total.ToString();
        }

        protected void btnPagar_Click(object sender, EventArgs e)
        {
            if (Request.QueryString["vehiculoId"] == null)
            {
                Response.Redirect("Payments.aspx");
            }
            else
            {
                int idVehiculo = Convert.ToInt32(Request.QueryString["vehiculoId"]);
                Response.Redirect($"~/Payments.aspx?id={idVehiculo}");
            } 
        }
    }
}