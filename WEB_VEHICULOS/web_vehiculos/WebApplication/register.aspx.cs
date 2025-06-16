using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Text.RegularExpressions;
using Library; 
using Library.CAD; 

namespace WebApplication
{
    public partial class register : System.Web.UI.Page
    {
        protected void registrar(object sender, EventArgs e)
        {
            // esta ver si la página es válida antes de continuar
            if (!Page.IsValid)
            {
                return;
            }

            //  las contrasenyasas del formulario
            string passwd = txtPassword.Text;
            string confirmPasswd = txtConfirmPassword.Text;

            // hacemos si las contraseñas coinciden
            if (passwd != confirmPasswd)
            {
                lblErrorMessage.Text = "Las contraseñas no coinciden.";
                return;
            }

            // utilizamos una expresión regular para validar la complejidad de la contraseña
            Regex regex = new Regex(@"^(?=.*[a-zA-Z])(?=.*\d)(?=.*\W).*$");
            // siguimos si la contraseña cumple con los criterios de complejidad
            if (passwd.Length < 8 || !regex.IsMatch(passwd))
            {
                lblErrorMessage.Text = "La contraseña debe tener al menos 8 caracteres e incluir letras, números y símbolos.";
                return;
            }

            //  del número de teléfono  debe ser exactamente 9 dígitos
            if (txtTelefono.Text.Length != 9)
            {
                lblErrorMessage.Text = "El número de teléfono debe tener exactamente 9 dígitos.";
                return;
            }

            //  expresión regular para validar el formato del correo electrónico
            Regex emailRegex = new Regex(@"^[\w-\.]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$");
            //  el correo electrónico tiene ener un formato válido
            if (!emailRegex.IsMatch(txtEmail.Text))
            {
                lblErrorMessage.Text = "El correo electrónico debe ser una dirección de correo válida.";
                return;
            }

            // Obtiene las iniciales del nombre y el primer apellido
            string firstNameInitial = txtNombre.Text.Substring(0, 1);
            string lastNameInitial = txtApellidos.Text.Substring(0, 1);
            // expresión regular para validar el username
            Regex userRegex = new Regex(@"^" + firstNameInitial + lastNameInitial + @"\d{2}$");
            // pruebamos si el nombre de usuario cumple con el formato 
            if (!userRegex.IsMatch(txtUsername.Text))
            {
                lblErrorMessage.Text = "El nombre de usuario debe ser una abreviatura de las iniciales del nombre y el primer apellido seguidas de dos dígitos.";
                return;
            }

            // el código postal debe tener exactamente 5 dígitos
            if (!Regex.IsMatch(txtCodigoPostal.Text, @"^\d{5}$"))
            {
                lblErrorMessage.Text = "El código postal debe ser un número de 5 dígitos.";
                return;
            }

            // Creamos un nuevo objeto de usuario con los datos del formulario
            ENUsuario nuevoUsuario = new ENUsuario
            {
                Username = txtUsername.Text,
                Nombre = txtNombre.Text,
                Apellidos = txtApellidos.Text,
                Telefono = txtTelefono.Text,
                Contrasenya = passwd,
                Calle = txtCalle.Text,
                Localidad = txtLocalidad.Text,
                Provincia = txtProvincia.Text,
                Codigo_Postal = txtCodigoPostal.Text,
                Email = txtEmail.Text,
                Admin = false
            };

            // compruebamos si el correo electrónico ya está en uso en la base de datos
            if (new CADUsuario().FindUsuarioByEmail(nuevoUsuario))
            {
                lblErrorMessage.Text = "El correo electrónico ya está en uso.";
                return;
            }

            // Vamos a ver si el nombre de usuario ya está en uso en la base de datos
            if (new CADUsuario().FindUsuarioByUsername(nuevoUsuario))
            {
                lblErrorMessage.Text = "El nombre de usuario ya está en uso.";
                return;
            }

            // si creamos un nuevo usuario en la base de datos
            if (nuevoUsuario.createUsuario())
            {
                // hacemos que se aparezca un mensaje de éxito y redirige al usuario a la página de inicio de sesión
                lblSuccessMessage.Text = "Usuario creado exitosamente! Redirigiendo a Login...";
                lblSuccessMessage.Visible = true;
                HttpContext.Current.Session["usuarios"] = nuevoUsuario;
                ClientScript.RegisterStartupScript(this.GetType(), "redirectScript", "redirectToLogin();", true);
            }
            else
            {
                // Muestra un mensaje de error acaso si no se peude crear el usuario
                lblErrorMessage.Text = "Error al crear el usuario.";
            }
        }

        //  validar el dominio del correo electrónico
        protected void ValidateEmailDomain(object source, ServerValidateEventArgs args)
        {
            Regex emailRegex = new Regex(@"^[\w-\.]+@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$");
            args.IsValid = emailRegex.IsMatch(args.Value);
        }

        //  validar el nombre de usuario
        protected void ValidateUsername(object source, ServerValidateEventArgs args)
        {
            // comprobamos  si el nombre y los apellidos no están vacíos
            if (string.IsNullOrEmpty(txtNombre.Text) || string.IsNullOrEmpty(txtApellidos.Text))
            {
                args.IsValid = false;
                return;
            }

            // Obtiene las iniciales del nombre y el primer apellido
            string firstNameInitial = txtNombre.Text.Substring(0, 1);
            string lastNameInitial = txtApellidos.Text.Substring(0, 1);
            // expresión regular para validar el nombre de usuario
            Regex userRegex = new Regex(@"^" + firstNameInitial + lastNameInitial + @"\d{2}$");
            args.IsValid = userRegex.IsMatch(args.Value);
        }

        //  verificar si el nombre de usuario ya está en uso
        protected void ValidateUsernameInUse(object source, ServerValidateEventArgs args)
        {
            ENUsuario nuevoUsuario = new ENUsuario
            {
                Username = args.Value
            };

            args.IsValid = !new CADUsuario().FindUsuarioByUsername(nuevoUsuario);
        }

        //  verificar si el correo electrónico ya está en uso
        protected void ValidateEmailInUse(object source, ServerValidateEventArgs args)
        {
            ENUsuario nuevoUsuario = new ENUsuario
            {
                Email = args.Value
            };

            args.IsValid = !new CADUsuario().FindUsuarioByEmail(nuevoUsuario);
        }

        //  verificar si el número de teléfono ya está en uso
        protected void ValidateTelefonoInUse(object source, ServerValidateEventArgs args)
        {
            ENUsuario nuevoUsuario = new ENUsuario
            {
                Telefono = args.Value
            };

            args.IsValid = !new CADUsuario().FindUsuarioByTelefono(nuevoUsuario);
        }

        protected void Page_Load(object sender, EventArgs e)
        {
            // va a la página de inicio si ya ha iniciado sesión
            if (HttpContext.Current.Session["usuarios"] != null)
            {
                Response.Redirect("/Default.aspx");
            }
        }
    }
}
