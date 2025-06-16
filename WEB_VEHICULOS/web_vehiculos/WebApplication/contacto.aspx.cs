using System;
using System.IO; 
using System.Net;
using System.Net.Mail; 
using System.Web.UI;

namespace WebApplication
{
    public partial class contacto : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)   
        {
        }

        protected void btnSend_Click(object sender, EventArgs e)
        {
            try
            {
                
                string fromEmail = txtFrom.Text;
                string toEmail = txtTo.Text;
                string subject = txtSubject.Text;
                string message = txtMessage.Text;
                string attachmentPath = fileAttachment.PostedFile.FileName;

                // Crear un objeto de correo electrónico
                MailMessage mail = new MailMessage();
                mail.From = new MailAddress(fromEmail);
                mail.To.Add(toEmail);
                mail.Subject = subject;
                mail.Body = message;

                // Adjuntar archivo si se selecciona uno
                if (fileAttachment.HasFile)
                {
                    string fileName = Path.GetFileName(attachmentPath);
                    mail.Attachments.Add(new Attachment(fileAttachment.PostedFile.InputStream, fileName));
                }

                // Configurar el cliente SMTP para enviar el correo electrónico
                SmtpClient smtpClient = new SmtpClient("smtp.gmail.com", 587);
                smtpClient.EnableSsl = true;
                smtpClient.UseDefaultCredentials = false;
                smtpClient.Credentials = new NetworkCredential("onlycars162@gmail.com", "ilmz qhpn fwqs bibg");

              
                smtpClient.Send(mail);

                
                txtFrom.Text = string.Empty;
                txtTo.Text = string.Empty;
                txtSubject.Text = string.Empty;
                txtMessage.Text = string.Empty;

                // Mostrar mensaje de éxito
                Response.Write("<script>alert('✅ enviado correctamente.');</script>");
            }
            catch (Exception ex)
            {
                // Mostrar mensaje de error en caso de fallo
                Response.Write("<script>alert('Error al enviar el correo electrónico: " + ex.Message + "');</script>");
            }
        }
    }
}