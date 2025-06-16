using System;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Library;
using Library.CAD;
using System.Text.RegularExpressions;
using System.Net;
using System.Net.Mail;

namespace WebApplication
{
    
    public partial class user : System.Web.UI.Page
    {
        
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                if (Session["usuarios"] != null) 
                {
                    ENUsuario user = (ENUsuario)Session["usuarios"];
                    LoadUserData(user); 
                    SetAdminButtonVisibility(user); // para que  el botón de administrador sea visible
                }
                else
                {
                    Response.Redirect("~/login.aspx");
                }
                lblSuccessMessage.Visible = false; 
                lblErrorMessage.Visible = false; 
            }
        }

        //  los datos del usuario en el formulario lo cargamos
        private void LoadUserData(ENUsuario user)
        {
            lblUsername.Text = user.Username;
            txtName.Text = user.Nombre;
            txtSurname.Text = user.Apellidos;
            txtMobileNumber.Text = user.Telefono;
            txtAddressLine1.Text = user.Calle;
            txtPostcode.Text = user.Codigo_Postal;
            txtState.Text = user.Localidad;
            txtEmailID.Text = user.Email;
            txtArea.Text = user.Provincia;
        }

        //  si pulsamos el botón de cerrar sesión
        protected void btnLogOut_Click(object sender, EventArgs e)
        {
            Session["usuarios"] = null; //esto user se elimina
            Response.Redirect("~/login.aspx"); 
        }

        // cuando pulsamos  en el botón de editar perfil
        protected void btnEditProfile_Click(object sender, EventArgs e)
        {
            ToggleProfileEditing(true); // el perfil se edita
        }

        // cuando pulsamos el botón de guardar perfil
        protected void btnSaveProfile_Click(object sender, EventArgs e)
        {
            if (Session["usuarios"] != null) //  si hay un usuario en la sesión
            {
                try
                {
                    ENUsuario user = (ENUsuario)Session["usuarios"];
                    // Actualiza los datos del usuario con la información del formulario
                    user.Nombre = txtName.Text;
                    user.Apellidos = txtSurname.Text;
                    user.Telefono = txtMobileNumber.Text;
                    user.Calle = txtAddressLine1.Text;
                    user.Codigo_Postal = txtPostcode.Text;
                    user.Localidad = txtState.Text;
                    user.Provincia = txtArea.Text;
                    user.Email = txtEmailID.Text;

                    CADUsuario cadUsuario = new CADUsuario();
                    if (cadUsuario.UpdateUsuario(user)) // el usuario en la base de datos se actualiza
                    {
                        lblSuccessMessage.Text = "Perfil actualizado con éxito!";
                        lblSuccessMessage.ForeColor = System.Drawing.Color.Green;
                        lblSuccessMessage.Visible = true;
                        ToggleProfileEditing(false); // Desactiva la edición del perfil
                    }
                    else
                    {
                        lblErrorMessage.Text = "Error al actualizar el perfil.";
                        lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                        lblErrorMessage.Visible = true;
                    }
                }
                catch (Exception ex) 
                {
                    lblErrorMessage.Text = "Excepción: " + ex.Message;
                    lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                    lblErrorMessage.Visible = true;
                }
            }
        }

        // activar o desactivar la edición del perfil
        private void ToggleProfileEditing(bool enable)
        {
            txtName.Enabled = enable;
            txtSurname.Enabled = enable;
            txtMobileNumber.Enabled = enable;
            txtAddressLine1.Enabled = enable;
            txtPostcode.Enabled = enable;
            txtState.Enabled = enable;
            txtArea.Enabled = enable;
            txtEmailID.Enabled = enable;
            btnSaveProfile.Visible = enable;
            btnEditProfile.Visible = !enable;
        }

        // cuando pulsamos en el botón de vender
        protected void btnSell_Click(object sender, EventArgs e)
        {
            Response.Redirect("venta.aspx"); // Redirige a la página de venta
        }

        // al pulsar en el botón de pedido
        protected void btnpedido_Click(object sender, EventArgs e)
        {
            Response.Redirect("Carrito.aspx"); 
        }

        
        protected void btncompra_Click(object sender, EventArgs e)
        {
            Response.Redirect("Catalogo.aspx"); 
        }

        // al pulsar el botón de cambiar contraseña
        protected void btnChangePassword_Click(object sender, EventArgs e)
        {
            ToggleChangePassword(true); // true entonces Activa la edición de la contraseña
        }

        // al pulsar el botón de enviar cambio de contraseña
        protected void btnSubmitPasswordChange_Click(object sender, EventArgs e)
        {
            if (Session["usuarios"] != null) // si hay un usuario en la sesión
            {
                ENUsuario user = (ENUsuario)Session["usuarios"];
                string newPassword = txtNewPassword.Text;
                string confirmPassword = txtConfirmPassword.Text;

                // Validación de la contraseña
                if (newPassword != confirmPassword)
                {
                    lblErrorMessage.Text = "Las contraseñas no coinciden.";
                    lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                    lblErrorMessage.Visible = true;
                    lblSuccessMessage.Visible = false; 
                    return;
                }

                // Verifica si contrasenya es valida
                Regex regex = new Regex(@"^(?=.*[a-zA-Z])(?=.*\d)(?=.*\W).*$");
                if (newPassword.Length < 8 || !regex.IsMatch(newPassword))
                {
                    lblErrorMessage.Text = "La contraseña debe tener al menos 8 caracteres e incluir letras, números y símbolos.";
                    lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                    lblErrorMessage.Visible = true;
                    lblSuccessMessage.Visible = false; 
                    return;
                }

                user.Contrasenya = newPassword; // la contraseña del usuario se actualiza

                CADUsuario cadUsuario = new CADUsuario();
                if (cadUsuario.ChangePassword(user)) //  eto para cambiar la contraseña en la base de datos
                {
                    lblSuccessMessage.Text = "Contraseña actualizada con éxito!";
                    lblSuccessMessage.ForeColor = System.Drawing.Color.Green;
                    lblSuccessMessage.Visible = true;
                    lblErrorMessage.Visible = false; 

                    //  usamos metodo como lo hice en frogotpassword ,enviar correo electrónico con la nueva contraseña
                    string toEmail = user.Email;
                    string subject = "Tu contraseña ha sido cambiada";
                    string body = $"Hola {user.Nombre},<br/><br/>Tu contraseña ha sido actualizada con éxito. Tu nueva contraseña es: {newPassword}<br/><br/>Gracias.";
                    try
                    {
                        SendEmail(toEmail, subject, body);

                        // Mostrar mensaje de éxito
                        Response.Write("<script>alert('✅ enviado correctamente.');</script>");
                    }
                    catch (Exception ex) // Manejo de excepciones al enviar el correo
                    {
                        // Mostrar mensaje de error en caso de fallo
                        Response.Write("<script>alert('Error al enviar el correo electrónico: " + ex.Message + "');</script>");
                    }

                    ToggleChangePassword(false); // false para desactivar la edición de la contraseña
                }
                else
                {
                    lblErrorMessage.Text = "Error al actualizar la contraseña.";
                    lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                    lblErrorMessage.Visible = true;
                    lblSuccessMessage.Visible = false; 
                }
            }
        }

        // Método para enviar un correo electrónico
        public void SendEmail(string toEmail, string subject, string body)
        {
            string fromEmail = "onlycars162@gmail.com";
            string fromPassword = "ilmz qhpn fwqs bibg"; // Contraseña de la cuenta de correo pero es aplicaion no de coreo

            SmtpClient smtp = new SmtpClient
            {
                Host = "smtp.gmail.com", // Servidor SMTP de Gmail
                Port = 587,
                EnableSsl = true,
                DeliveryMethod = SmtpDeliveryMethod.Network,
                UseDefaultCredentials = false,
                Credentials = new NetworkCredential(fromEmail, fromPassword)
            };

            using (MailMessage message = new MailMessage(fromEmail, toEmail)
            {
                Subject = subject,
                Body = body,
                IsBodyHtml = true 
            })
            {
                smtp.Send(message); 
            }
        }

        // para activar o desactivar la edición de la contraseña
        private void ToggleChangePassword(bool enable)
        {
            changePasswordFields.Visible = enable;
            btnSubmitPasswordChange.Visible = enable;
        }

        // pulsar el botón de cancelar cambio de contraseña
        protected void btnCancelPasswordChange_Click(object sender, EventArgs e)
        {
            changePasswordFields.Visible = false; 
        }

        // pulsar el botón de eliminar cuenta
        protected void btnDeleteAccount_Click(object sender, EventArgs e)
        {
            pnlConfirmDelete.Visible = true; 
        }

        // el botón de confirmar eliminación
        protected void btnConfirmDelete_Click(object sender, EventArgs e)
        {
            if (Session["usuarios"] != null) //  si hay un usuario en la sesión
            {
                ENUsuario user = (ENUsuario)Session["usuarios"];
                string errorMessage;

                if (user.DeleteUsuario(out errorMessage)) 
                {
                    Session["usuarios"] = null; // Elimina el usuario de la sesión
                    Response.Redirect("~/login.aspx"); 
                }
                else
                {
                    lblErrorMessage.Text = "Error al eliminar la cuenta: " + errorMessage;
                    lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                    lblErrorMessage.Visible = true;
                }
            }
        }

        //  el botón de cancelar eliminación
        protected void btnCancelDelete_Click(object sender, EventArgs e)
        {
            pnlConfirmDelete.Visible = false; 
        }

        // visibilidad del botón de administrador
        private void SetAdminButtonVisibility(ENUsuario user)
        {
            btnAdmin.Visible = user.Admin; // El botón es visible solo si el usuario es administrador
        }

        //si el botón de administrador es visible
        protected bool IsAdminVisible(object admin)
        {
            return Convert.ToBoolean(admin);
        }

        // pulsar el botón de administrador
        protected void btnAdmin_Click(object sender, EventArgs e)
        {
            
            Response.Redirect("AdminPage.aspx");
        }

        //  si el botón de administrador es visible
        protected bool IsAdminVisible()
        {
            if (Session["usuarios"] != null)
            {
                ENUsuario usuario = (ENUsuario)Session["usuarios"];
                return usuario.Admin;
            }
            return false;
        }
    }
}
