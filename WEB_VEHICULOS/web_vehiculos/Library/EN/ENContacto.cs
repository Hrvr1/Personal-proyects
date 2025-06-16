using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    internal class ENContacto
    {

        private int Id;
        private string Nombre;
        private string Email;
        private string Telefono;
        private string Mensaje;
        private DateTime FechaContacto;

        public int id { get => Id; set => Id = value; }
        public string nombre { get => Nombre; set => Nombre = value; }
        public string email { get => Email; set => Email = value; }
        public string telefono { get => Telefono; set => Telefono = value; }
        public string mensaje { get => Mensaje; set => Mensaje = value; }
        public DateTime fechaContacto { get => FechaContacto; set => FechaContacto = value; }

        public ENContacto()
        {
            FechaContacto = DateTime.Now;
        }

        public ENContacto(int id)
        {
            Id = id;
            FechaContacto = DateTime.Now;
        }

        public ENContacto(string nombre, string email, string telefono, string mensaje)
        {
            Nombre = nombre;
            Email = email;
            Telefono = telefono;
            Mensaje = mensaje;
            FechaContacto = DateTime.Now;
        }


        public bool crearContacto()
        {
            CADContacto cadContacto = new CADContacto();
            return cadContacto.crearContacto(this);
        }

        public ENContacto leerContacto()
        {
            CADContacto cadContacto = new CADContacto();
            return cadContacto.leerContacto(this.Id);
        }

        public bool editarContacto()
        {
            CADContacto cadContacto = new CADContacto();
            return cadContacto.editarContacto(this);
        }

        public bool eliminarContacto()
        {
            CADContacto cadContacto = new CADContacto();
            return cadContacto.eliminarContacto(this.Id);
        }

        public List<ENContacto> obtenerTodosLosContactos()
        {
            CADContacto cadContacto = new CADContacto();
            return cadContacto.obtenerTodosLosContactos();
        }
    }
}
