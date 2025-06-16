using Library;
using Library.CAD;
using System;
using System.Data;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace WebApplication
{
    
    public partial class AdminPage : System.Web.UI.Page
    {
        
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack) 
            {
                
            }
        }

  
        protected void ButtonMostrarUsuarios_Click(object sender, EventArgs e)
        {
            PanelUsuarios.Visible = true; // aparecer el panel de usuarios
            PanelArticulos.Visible = false; // Oculta el panel de artículos
            LoadUsuarios(); // para que se hacer download o cargar la lista de usuarios
        }

        // el botón de mostrar artículos
        protected void ButtonMostrarVehiculos_Click(object sender, EventArgs e)
        {
            PanelUsuarios.Visible = false; //no va a ser visible
            PanelArticulos.Visible = true; // si  los articulos van a aser visible l
            LoadVehiculos(); 
        }

        // para cargar la lista de usuarios desde la base de datos
        private void LoadUsuarios()
        {
            CADUsuario cadUsuario = new CADUsuario();
            DataTable dt = cadUsuario.GetUsuarios(); // get los usuarios de la base de datos
            GridViewUsuarios.DataSource = dt; // datos al GridView
            GridViewUsuarios.DataBind(); // los datos al GridView se enlacen
        }

        // cargar la lista de artículos desde la base de datos
        private void LoadVehiculos()
        {
            CADVehiculo cadVehiculo = new CADVehiculo();
            DataTable dt = cadVehiculo.GetVehiculo();
            GridViewVehiculos.DataSource = dt;
            GridViewVehiculos.DataBind(); 
        }

        // este es un panel para ver los usarios y manejarlos
        protected void GridViewUsuarios_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            if (e.CommandName == "DeleteUser") 
            {
                string username = e.CommandArgument.ToString(); 
                ENUsuario currentUser = (ENUsuario)Session["usuarios"]; 
                CADUsuario cadUsuario = new CADUsuario();

                if (!currentUser.Admin) // si el usuario actual no es administrador
                {
                    ShowErrorMessage("No tienes permisos para eliminar usuarios."); 
                    return;
                }

                ENUsuario userToDelete = new ENUsuario { Username = username }; 
                string errorMessage;

                if (cadUsuario.FindUsuarioByUsername(userToDelete)) 
                {
                    if (userToDelete.Admin) //  si el usuario a eliminar es administrador
                    {
                        ShowErrorMessage("No puedes eliminar a otro administrador."); 
                        return;
                    }

                    if (cadUsuario.DeleteUsuario(userToDelete.Username, out errorMessage)) 
                    {
                        LoadUsuarios(); 
                        ShowSuccessMessage("Usuario eliminado con éxito!"); 
                    }
                    else
                    {
                        ShowErrorMessage("Error al eliminar el usuario: " + errorMessage); 
                    }
                }
                else
                {
                    ShowErrorMessage("Usuario no encontrado."); 
                }
            }
        }

        //  mensaje de éxito
        private void ShowSuccessMessage(string message)
        {
            lblSuccessMessage.Text = message;
            lblSuccessMessage.ForeColor = System.Drawing.Color.Green;
            lblSuccessMessage.Visible = true;
            lblErrorMessage.Visible = false; 
        }

        //  mensaje de error
        private void ShowErrorMessage(string message)
        {
            lblErrorMessage.Text = message;
            lblErrorMessage.ForeColor = System.Drawing.Color.Red;
            lblErrorMessage.Visible = true;
            lblSuccessMessage.Visible = false; 
        }

        protected void GridViewVehiculos_RowCommand(object sender, GridViewCommandEventArgs e)
        {
            if (e.CommandName == "DeleteVehiculo")
            {
                int vehiculoID = Convert.ToInt32(e.CommandArgument);
                CADVehiculo cadVehiculo = new CADVehiculo();

                if (cadVehiculo.DeleteVehiculo(vehiculoID))
                {
                    LoadVehiculos();
                    ShowArticuloSuccessMessage("Vehículo eliminado con éxito!");
                }
                else
                {
                    ShowArticuloErrorMessage("Error al eliminar el vehículo.");
                }
            }
            else if (e.CommandName == "ToggleVendido")
            {
                int vehiculoID = Convert.ToInt32(e.CommandArgument);
                CADVehiculo cadVehiculo = new CADVehiculo();

                if (cadVehiculo.ToggleVendido(vehiculoID))
                {
                    LoadVehiculos();
                    ShowArticuloSuccessMessage("Estado de 'vendido' actualizado con éxito!");
                }
                else
                {
                    ShowArticuloErrorMessage("Error al actualizar el estado de 'vendido' del vehículo.");
                }
            }
        }


        private void ShowArticuloSuccessMessage(string message)
        {
            lblArticuloSuccessMessage.Text = message;
            lblArticuloSuccessMessage.ForeColor = System.Drawing.Color.Green;
            lblArticuloSuccessMessage.Visible = true;
        }

        
        private void ShowArticuloErrorMessage(string message)
        {
            lblArticuloErrorMessage.Text = message;
            lblArticuloErrorMessage.ForeColor = System.Drawing.Color.Red;
            lblArticuloErrorMessage.Visible = true;
        }

        //  botón de mostrar página completa del panel mejoras
        protected void btnMostrarPaginaCompleta_Click(object sender, EventArgs e)
        {
            Response.Redirect("Mejoras.aspx"); 
        }
    }
}
