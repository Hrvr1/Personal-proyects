using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Library.CAD;

namespace Library
{
    public class ENUsuario
    {
        public string username;
        private string nombre;
        private string apellidos;
        private string email;
        private string telefono;
        private string contrasenya;
        private string calle;
        private string localidad;
        private string provincia;
        private string codigo_postal;
        private bool admin;

        public string Username
        {
            get { return username; }
            set { username = value; }
        }



        public string Nombre
        {
            get { return nombre; }
            set { nombre = value; }
        }

        public string Apellidos
        {
            get { return apellidos; }
            set { apellidos = value; }
        }

        public string Email
        {
            get { return email; }
            set { email = value; }
        }

        public string Telefono
        {
            get { return telefono; }
            set { telefono = value; }
        }

        public string Contrasenya
        {
            get { return contrasenya; }
            set { contrasenya = value; }
        }

        public string Localidad
        {
            get { return localidad; }
            set { localidad = value; }
        }

        public string Provincia
        {
            get { return provincia; }
            set { provincia = value; }
        }

        public string Codigo_Postal
        {
            get { return codigo_postal; }
            set { codigo_postal = value; }
        }

        public string Calle
        {
            get { return calle; }
            set { calle = value; }
        }


        public bool Admin
        {
            get { return admin; }
            set { admin = value; }
        }


        public ENUsuario()
        {
            Username = "";
            Nombre = "";
            Apellidos = "";
            Telefono = "";
            Contrasenya = "";
            Calle = "";
            Localidad = "";
            Provincia = "";
            Codigo_Postal = "";
            Email = "";
            Admin = false;
        }

        public ENUsuario(string username, string nombre, string apellidos, string telefono,
                         string contrasenya, string calle, string localidad, string provincia,
                         string codigoPostal, string email, bool admin)
        {
            Username = username;
            Nombre = nombre;
            Apellidos = apellidos;
            Telefono = telefono;
            Contrasenya = contrasenya;
            Calle = calle;
            Localidad = localidad;
            Provincia = provincia;
            Codigo_Postal = codigoPostal;
            Email = email;
            Admin = admin;
        }

        public bool createUsuario()
        {
            CADUsuario user = new CADUsuario();
            bool creado = false;

            creado = user.CreateUsuario(this);

            return creado;
        }

        public bool UpdateUsuario()
        {
            CADUsuario usuario = new CADUsuario();
            ENUsuario usu = new ENUsuario();
            bool updated = false;

            if (usuario.FindUsuario(usu))
                updated = usuario.UpdateUsuario(this);

            return updated;
        }

        public bool ChangePassword()
        {
            CADUsuario usuario = new CADUsuario();
            ENUsuario usu = new ENUsuario();
            bool changed = false;

            if (usuario.FindUsuario(usu))
                changed = usuario.ChangePassword(this);

            return changed;
        }

        public bool DeleteUsuario(out string errorMessage)
        {
            CADUsuario usuario = new CADUsuario();
            return usuario.DeleteUsuario(username, out errorMessage);
        }

        public bool FindUsuario()
        {
            CADUsuario usuario = new CADUsuario();

            return usuario.FindUsuario(this);
        }

        public bool ValidarContrasena(string inputPassword)
        {
            return inputPassword == this.Contrasenya;
        }


        public bool FindUsuarioByEmail()
        {
            CADUsuario cadUsuario = new CADUsuario();
            return cadUsuario.FindUsuarioByEmail(this);
        }








    }
}
