using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Library;

namespace WebApplication
{
    public partial class login : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                // la sesión de usuario en cada carga de página se restableza
                Session["usuarios"] = null;

                // si hay cookies para los emails y las contraseñas para comprobar
                if (Request.Cookies["UserCredentials"] != null)
                {
                    // Cargar las credenciales guardadas en las cookies si están disponibles
                    HttpCookie credentialsCookie = Request.Cookies["UserCredentials"];
                    string[] credentials = credentialsCookie.Value.Split('&');

                    foreach (string credential in credentials)
                    {
                        string[] parts = credential.Split('=');
                        if (parts[0] == txtEmail.Text.Trim())
                        {
                            //  si se encuentra el correo electrónico correspondiente , la contraseña almacenada se muestra
                            txtPassword.Attributes["value"] = parts[1];
                            chkRememberMe.Checked = true;
                            break;
                        }
                    }
                }
            }
        }

        protected void Inicio(object sender, EventArgs e)
        {
            // Crear una instancia de usuario
            ENUsuario user = new ENUsuario();
            user.Email = txtEmail.Text.Trim();
            string inputPassword = txtPassword.Text;

            // Buscar el usuario por correo electrónico
            if (user.FindUsuarioByEmail())
            {
                // Validar la contraseña del usuario
                if (user.ValidarContrasena(inputPassword))
                {
                    // Si la casilla "Recuérdame" está marcada, guardar las credenciales en cookies
                    if (chkRememberMe.Checked)
                    {
                        //  la cookie de las credenciales del usuario lo actualizamos
                        HttpCookie credentialsCookie;
                        if (Request.Cookies["UserCredentials"] != null)
                        {
                            credentialsCookie = Request.Cookies["UserCredentials"];
                            string newCredentials = txtEmail.Text.Trim() + "=" + txtPassword.Text;
                            credentialsCookie.Value = credentialsCookie.Value + "&" + newCredentials;
                        }
                        else
                        {
                            credentialsCookie = new HttpCookie("UserCredentials");
                            credentialsCookie.Value = txtEmail.Text.Trim() + "=" + txtPassword.Text;
                        }
                        credentialsCookie.Expires = DateTime.Now.AddDays(30);
                        Response.Cookies.Add(credentialsCookie);
                    }
                    else
                    {
                        // eliminar las credenciales del usuario de las cookies Si no está marcada, 
                        if (Request.Cookies["UserCredentials"] != null)
                        {
                            HttpCookie credentialsCookie = Request.Cookies["UserCredentials"];
                            string[] credentials = credentialsCookie.Value.Split('&');
                            string newCookieValue = string.Empty;

                            foreach (string credential in credentials)
                            {
                                string[] parts = credential.Split('=');
                                if (parts[0] != txtEmail.Text.Trim())
                                {
                                    if (!string.IsNullOrEmpty(newCookieValue))
                                    {
                                        newCookieValue += "&";
                                    }
                                    newCookieValue += credential;
                                }
                            }

                            if (!string.IsNullOrEmpty(newCookieValue))
                            {
                                credentialsCookie.Value = newCookieValue;
                                Response.Cookies.Add(credentialsCookie);
                            }
                            else
                            {
                                //  si no hay más credenciales almacenadas  lo eliminamos la cookie
                                credentialsCookie.Expires = DateTime.Now.AddDays(-1);
                                Response.Cookies.Add(credentialsCookie);
                            }
                        }
                    }

                    //  la sesión de usuario y redirigir a la página de usuario
                    Session["usuarios"] = user;
                    Response.Redirect("user.aspx");
                }
                else
                {
                    // Mostrar un mensaje de error si la contraseña es incorrecta
                    lblErrorMessage.Text = "Contraseña incorrecta";
                    lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                    lblErrorMessage.Visible = true;
                }
            }
            else
            {
                // Mostrar un mensaje de error si el usuario no se encuentra
                lblErrorMessage.Text = "Usuario no encontrado";
                lblErrorMessage.ForeColor = System.Drawing.Color.Red;
                lblErrorMessage.Visible = true;
            }
        }

        protected void txtEmail_TextChanged(object sender, EventArgs e)
        {
            // si el correo electrónico cambia y las cookies están aqui ,cargamonamos la contraseña correspondiente
            if (Request.Cookies["UserCredentials"] != null)
            {
                HttpCookie credentialsCookie = Request.Cookies["UserCredentials"];
                string[] credentials = credentialsCookie.Value.Split('&');

                foreach (string credential in credentials)
                {
                    string[] parts = credential.Split('=');
                    if (parts[0] == txtEmail.Text.Trim())
                    {
                        txtPassword.Attributes["value"] = parts[1];
                        break;
                    }
                }
            }
        }

        protected void txtPassword_TextChanged(object sender, EventArgs e)
        {
           
        }
    }
}
