using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    public class ENCarrito
    {
        private int carrito_id;
        private string usuario_name;

        public int Carrito_id
        {
            get { return carrito_id; }
            set { carrito_id = value; }
        }

        public string Usuario_name
        {
            get { return usuario_name; }
            set { usuario_name = value; }
        }

        public ENCarrito()
        {
        }

        public ENCarrito(string usuario)
        {
            this.usuario_name = usuario;
        }

        public ENCarrito(int carrito_id)
        {
            this.carrito_id = carrito_id;
        }

        public ENCarrito(int carrito_id, string usuario)
        {
            this.carrito_id = carrito_id;
            this.usuario_name = usuario;
        }

        public DataSet show()       
        {
            CADCarrito cadcarrito = new CADCarrito();
            return cadcarrito.Show(usuario_name);
        }

        public bool add(int vehiculoId)
        {
            CADCarrito cadCarrito = new CADCarrito();
            return cadCarrito.AddCarrito(usuario_name, vehiculoId);
        }

        public bool checkUser()
        {
            CADCarrito cadcarrito = new CADCarrito();
            return cadcarrito.CheckCarritoUser(usuario_name);
        }

        public bool addNewUser()
        {
            CADCarrito cadcarrito = new CADCarrito();
            return cadcarrito.AddCarritoNewUser(usuario_name);
        }

        public bool deleteOne()
        {
            CADCarrito cadCarrito = new CADCarrito();
            return cadCarrito.DeleteOne(usuario_name, carrito_id);
        }

        public bool deleteAll()
        {
            CADCarrito cadCarrito = new CADCarrito();
            return cadCarrito.DeleteAll(usuario_name);
        }

        public decimal precioTotal()
        {
            CADCarrito cadCarrito = new CADCarrito();
            return cadCarrito.PrecioTotal(usuario_name);
        }
    }
}
