using System;
using System.Web.UI;

namespace WebApplication
{
    public partial class ResumenAnuncio : Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                lblAño.Text = " " + (Session["AñoCoche"] ?? "No disponible");
                lblMarca.Text = " " + (Session["MarcaCoche"] ?? "No disponible");
                lblModelo.Text = " " + (Session["ModeloCoche"] ?? "No disponible");
                lblCombustible.Text = " " + (Session["CombustibleCoche"] ?? "No disponible");
                lblTransmision.Text = " " + (Session["TransmisionCoche"] ?? "No disponible");
                lblColor.Text = " " + (Session["ColorCoche"] ?? "No disponible");
                lblKilometros.Text = " " + (Session["KilometrosCoche"] ?? "No disponible");
                lblDescripcionAdicional.Text = "Descripción Adicional: " + (Session["DescripcionAdicionalCoche"] ?? "No disponible");
                lblPrecio.Text = " " + (Session["PrecioCoche"] ?? "No disponible");

                if (Session["UrlImagen"] != null)
                {
                    imgCar.ImageUrl = Session["UrlImagen"].ToString();
                    imgCar.Visible = true;
                }
                else
                {
                    imgCar.Visible = false;
                }
            }
        }
    }
}
