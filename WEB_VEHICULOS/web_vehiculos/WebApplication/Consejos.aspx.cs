using System;
using System.Text;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Library;
using Library.EN;
using Library.CAD;

namespace WebApplication
{
    public partial class Consejos : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }
        protected void ButonMostrarCompras_Click(object sender, EventArgs e)
        {
            LiteralCompras.Visible = !LiteralCompras.Visible;

            if (LiteralCompras.Visible)
            {
                MostrarConsejos("Compras");

            }
        }

        protected void ButonMostrarVentas_Click(object sender, EventArgs e)
        {
            LiteralVentas.Visible = !LiteralVentas.Visible;

            if (LiteralVentas.Visible)
            {
                MostrarConsejos("Ventas");
            }
        }
        protected void ButonMostrarGarantia_Click(object sender, EventArgs e)
        {
            LiteralGarantia.Visible = !LiteralGarantia.Visible;

            if (LiteralGarantia.Visible)
            {
                MostrarConsejos("Garantía OnlyCars");

            }
        }
        protected void ButonMostrarServicio_Click(object sender, EventArgs e)
        {
            LiteralServicio.Visible = !LiteralServicio.Visible;

            if (LiteralServicio.Visible)
            {
                MostrarConsejos("Servicio de mantenimiento");

            }
        }

        private void MostrarConsejos(string categoria)
        {
            // creacion de la instancia CADConsejos
            CADConsejos cadConsejos = new CADConsejos();

            // llamamos a getconsejos
            var consejos = cadConsejos.GetConsejos(categoria);
            StringBuilder html = new StringBuilder();

            foreach (var consejo in consejos)
            {
                if (consejo.Categoria_consejo == categoria)
                {
                    html.Append("<div class='consejo'>");
                    html.AppendFormat("<h3 style='margin-left: 20px;'>{0}</h3>", consejo.Pregunta_consejo);
                    html.AppendFormat("<p style='white-space: pre-wrap;margin-left: 20px;'>{0}</p>", HttpUtility.HtmlEncode(consejo.Respuesta_consejo));
                    html.Append("</div>");
                }
            }
            if(categoria == "Compras")
            {
                LiteralCompras.Text = html.ToString();
            }
            else if(categoria == "Ventas")
            {
                LiteralVentas.Text = html.ToString();
            }
            else if ((categoria == "Garantía OnlyCars") || (categoria == "Garantía Onlycars"))
            {
                LiteralGarantia.Text = html.ToString();
            }
            else if (categoria == "Servicio de mantenimiento")
            {
                LiteralServicio.Text = html.ToString();
            }
        }

    }
}