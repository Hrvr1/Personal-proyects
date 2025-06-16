using System;
using System.Data;
using System.Web.UI;
using System.Web.UI.WebControls;
using Library;

namespace WebApplication
{
    public partial class BandejaNotificacion : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                if (Session["usuarios"] == null)
                {
                    Response.Redirect("login.aspx");
                    return;
                }
                ENUsuario user = (ENUsuario)Session["usuarios"];
                string username = user.Username;

                CADLineaBandejaNotificacion cad = new CADLineaBandejaNotificacion();

                DataSet dataSet = cad.ListarNotificacionesPorUsuario(username);

                if (dataSet.Tables["LineaBandejaNotificacion"].Rows.Count > 0)
                {
                    // Cargar tipos de notificación en el DropDownList
                    CargarTiposNotificacion();

                    // Cargar notificaciones al cargar la página
                    CargarNotificaciones(username);
                }
                else
                {
                    Response.Redirect("~/NoNotificaciones.aspx");
                }
            }
        }
        protected void ddlTipoNotificacion_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (Session["usuarios"] != null)
            {
                ENUsuario user = (ENUsuario)Session["usuarios"];
                string username = user.Username;

                // Cargar notificaciones según el tipo seleccionado
                CargarNotificaciones(username);
            }
        }

        protected void Repeater_ItemCommand(object source, RepeaterCommandEventArgs e)
        {
            if (e.CommandName == "EliminarNotificacion")
            {
                int notificacionId = Convert.ToInt32(e.CommandArgument);
                EliminarNotificacion(notificacionId);
                Response.Redirect(Request.RawUrl); // Recargar la página después de eliminar la notificación
            }
            else if (e.CommandName == "VerVehiculo")
            {
                int vehiculoId = Convert.ToInt32(e.CommandArgument);
                Response.Redirect($"~/Vehiculo.aspx?id={vehiculoId}");
            }
        }

        private void EliminarNotificacion(int notificacionId)
        {
            CADLineaBandejaNotificacion cad = new CADLineaBandejaNotificacion();
            cad.EliminarNotificacionPorId(notificacionId);
        }

        private void CargarTiposNotificacion()
        {
            CADLineaBandejaNotificacion cad = new CADLineaBandejaNotificacion();
            ddlTipoNotificacion.DataSource = cad.ObtenerTiposNotificacion();
            ddlTipoNotificacion.DataBind();
            ddlTipoNotificacion.Items.Insert(0, new ListItem("-- Todos --", ""));
        }

        private void CargarNotificaciones(string username)
        {
            CADLineaBandejaNotificacion cad = new CADLineaBandejaNotificacion();

            string tipoNotificacionSeleccionado = ddlTipoNotificacion.SelectedValue;

            DataSet dataSet;

            if (!string.IsNullOrEmpty(tipoNotificacionSeleccionado))
            {
                dataSet = cad.ListarNotificacionesPorUsuarioYTipo(username, tipoNotificacionSeleccionado);
            }
            else
            {
                dataSet = cad.ListarNotificacionesPorUsuario(username);
            }

            if (dataSet.Tables["LineaBandejaNotificacion"].Rows.Count > 0)
            {
                resultsRepeater.DataSource = dataSet.Tables["LineaBandejaNotificacion"];
                resultsRepeater.DataBind();
            }
            else
            {
                Response.Redirect("~/NoNotificaciones.aspx");
            }
        }
    }
}
