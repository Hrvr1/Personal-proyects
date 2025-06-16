using System;
using System.Data;
using System.Net;
using System.Net.Mail;
using Library;

namespace WebApplication
{
    public partial class Payments : System.Web.UI.Page
    {
        private CADMetodoPago cadMP = new CADMetodoPago();
        private CADPedido cadPedido = new CADPedido();
        private CADCarrito cadCarrito = new CADCarrito();

        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["usuarios"] == null)
            {
                Response.Redirect("login.aspx");
                return;
            }
        }

        protected void btnPagar_Click(object sender, EventArgs e)
        {
            EnviarCorreo();
            if (Request.QueryString["vehiculoId"] == null)
            {
                ENUsuario enusuario = (ENUsuario)Session["usuarios"];
                cadMP.PagarCarritoCompra(enusuario.username);
                cadCarrito.DeleteAll(enusuario.username);
            }
            else
            {
                int idVehiculo = Convert.ToInt32(Request.QueryString["vehiculoId"]);
                cadMP.PagarIdVehiculo(idVehiculo);
            }
            Response.Redirect("Default.aspx");
        }

        private void EnviarCorreo()
        {
            string asunto = "Factura de su Pedido";
            string cuerpo = GenerarCuerpoCorreo();
            ENUsuario enusuario = (ENUsuario)Session["usuarios"];

            MailMessage mail = new MailMessage("onlycars162@gmail.com", enusuario.Email, asunto, cuerpo);
            mail.IsBodyHtml = true;

            SmtpClient smtpClient = new SmtpClient("smtp.gmail.com", 587)
            {
                Credentials = new NetworkCredential("onlycars162@gmail.com", "ilmz qhpn fwqs bibg"),
                EnableSsl = true
            };

            try
            {
                smtpClient.Send(mail);
            }
            catch (Exception ex)
            {
                lblMensaje.Text = "Error al enviar el correo: " + ex.Message;
                lblMensaje.Visible = true;
            }
        }

        private string GenerarCuerpoCorreo()
        {
            DataSet vehiculos;
            if (Request.QueryString["vehiculoId"] == null)
            {
                ENUsuario enusuario = (ENUsuario)Session["usuarios"];
                vehiculos = cadPedido.ObtenerByCarritoCompra(enusuario.username);
            }
            else
            {
                int idVehiculo = Convert.ToInt32(Request.QueryString["vehiculoId"]);
                vehiculos = cadPedido.ObtenerByIdVehiculo(idVehiculo);
            }

            string cuerpo = "<h2>Factura de su Pedido</h2><table border='1' style='width: 100%;'>";
            cuerpo += "<tr><th>MARCA</th><th>MODELO</th><th>TRASMISIÓN</th><th>FECHA</th><th>PRECIO</th></tr>";

            foreach (DataRow row in vehiculos.Tables[0].Rows)
            {
                cuerpo += "<tr>";
                cuerpo += $"<td>{row["marca"]}</td>";
                cuerpo += $"<td>{row["modelo"]}</td>";
                cuerpo += $"<td>{row["auto_manu"]}</td>";
                cuerpo += $"<td>{DateTime.Now.ToString("dd/MM/yyyy")}</td>";
                cuerpo += $"<td>{Convert.ToDecimal(row["precio"]).ToString("C")}</td>";
                cuerpo += "</tr>";
            }

            cuerpo += "</table>";
            return cuerpo;
        }
    }
}



