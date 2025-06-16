using System;
using System.Net;
using System.Net.Mail;
using System.Web.UI;
using Library;
using Library.CAD;

namespace WebApplication
{
    public partial class ForgotPassword : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {  
           
        }

        protected void btnSubmit_Click(object sender, EventArgs e)
        {
            // Limpiamos para el mensaje de error 
            lblErrorMessage.Text = "";
            lblErrorMessage.Visible = false;

            // para sacar el correo  del usuario
            string email = txtEmail.Text.Trim();
            if (string.IsNullOrEmpty(email))
            {
                // esta valido si se proporcionó un correo electrónico
                lblErrorMessage.Text = "Please enter an email address.";
                lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                lblErrorMessage.Visible = true;
                return;
            }

            // la solicitud en proceso
            lblErrorMessage.Text = "Submit button clicked. Processing...";
            lblErrorMessage.ForeColor = System.Drawing.Color.Black;
            lblErrorMessage.Visible = true;

            // get el usuario asociado al correo electrónico proporpouesto
            ENUsuario user = GetUserByEmail(email);

            if (user != null)
            {
                // se envia el correo electrónico de recuperación ,si encuentra el usuario
                lblErrorMessage.Text = "User found. Sending email...";
                lblErrorMessage.ForeColor = System.Drawing.Color.Black;
                lblErrorMessage.Visible = true;

                SendEmail(user);

                // Mostrar el panel de confirmación y ocultar el formulario
                pnlForm.Visible = false;
                pnlConfirmation.Visible = true;
            }
            else
            {
                //  mostrar un mensaje de error si no se encontró el usuario
                lblErrorMessage.Text = "Email not found.";
                lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                lblErrorMessage.Visible = true;
            }
        }

        private ENUsuario GetUserByEmail(string email)
        {
            // get un usuario por su correo electrónico desde la base de datos

            ENUsuario user = new ENUsuario { Email = email };
            CADUsuario cadUsuario = new CADUsuario();

            try
            {
                if (cadUsuario.FindUsuarioByEmail(user))
                {
                    return user;
                }
                else
                {
                    return null;
                }
            }
            catch (Exception ex)
            {
                // Manejo de errores al tener el usuario de la base de datos
                lblErrorMessage.Text = "There was an error fetching user details. Error: " + ex.Message;
                lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                lblErrorMessage.Visible = true;
                return null;
            }
        }

        private void SendEmail(ENUsuario user)
        {
            // enviar un correo electrónico con los detalles de la cuenta del usuario

            try
            {
                string fromAddress = "onlycars162@gmail.com";
                string fromPassword = "ilmz qhpn fwqs bibg";
                string toAddress = user.Email;
                string subject = "Password Recovery";
                string body = $"Hola {user.Nombre},\n\nAquí están los detalles de tu cuenta:\n\nCorreo electrónico: {user.Email}\nContraseña: {user.Contrasenya}\n\nSaludos cordiales,\nEl equipo de ONLYCARS";

                // Configurar el correo electrónico y enviarlo
                MailMessage mail = new MailMessage();
                mail.From = new MailAddress(fromAddress);
                mail.To.Add(toAddress);
                mail.Subject = subject;
                mail.Body = body;

                SmtpClient smtpClient = new SmtpClient("smtp.gmail.com", 587);
                smtpClient.EnableSsl = true;
                smtpClient.UseDefaultCredentials = false;
                smtpClient.Credentials = new NetworkCredential(fromAddress, fromPassword);

                smtpClient.Send(mail);

                // Mostrar un mensaje de éxito si el correo electrónico se envió correctamente
                lblErrorMessage.Text = "Email has been sent successfully.";
                lblErrorMessage.ForeColor = System.Drawing.Color.Green;
                lblErrorMessage.Visible = true;
            }
            catch (Exception ex)
            {
                // Manejo de errores al intentar enviar el correo electrónico
                lblErrorMessage.Text = "There was an error sending the email. Please try again later. Error: " + ex.Message;
                lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                lblErrorMessage.Visible = true;
            }
        }
    }
}
