using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    public class ENVehiculo
    {
        private int vehiculo_id;
       // public string marca { get; set; }
        private int marca_id;
        private string modelo;
        private int kilometraje;
        private string color;
        private decimal precio; // cambiado a decimal
        private int anyo;
        private string auto_manu;
        private string combustible;
        private string descripcion;
        private decimal valoracion;
        private string url_imagen;
        private int vendido;
        private string vendedor_UName;

        public int Vehiculo_id
        {
            get { return vehiculo_id; }
            set
            {
                if (value < 1)
                {
                    throw new ArgumentException("El ID del vehículo debe ser mayor que 1.");
                }
                vehiculo_id = value;
            }
        }

        public int Marca_id
        {
            get { return marca_id; }
            set
            {
                if (value < 1)
                {
                    throw new ArgumentException("El ID de la marca debe ser mayor que 1.");
                }
                marca_id = value;
            }
        }

        public string Modelo
        {
            get { return modelo; }
            set
            {
                if (String.IsNullOrWhiteSpace(value))
                {
                    throw new ArgumentException("El modelo debe estar específicado.");
                }
                modelo = value;
            }
        }

        public int Kilometraje
        {
            get { return kilometraje; }
            set
            {
                if (value < 0)
                {
                    throw new ArgumentException("El kilometraje no puede ser menor que 0.");
                }
                kilometraje = value;
            }
        }

        public int Anyo
        {
            get { return anyo; }
            set
            {
                if (value < 1600)
                {
                    throw new ArgumentException("El año no es válido.");
                }
                anyo = value;
            }
        }

        public string Auto_Manu
        {
            get { return auto_manu; }
            set
            {
                if (String.IsNullOrWhiteSpace(value))
                {
                    throw new ArgumentException("La transmision debe estar específicada.");
                }
                auto_manu = value;
            }
        }

        public string Combustible
        {
            get { return combustible; }
            set
            {
                if (String.IsNullOrWhiteSpace(value))
                {
                    throw new ArgumentException("El combustible debe estar específicado.");
                }
                combustible = value;
            }
        }

        public string Descripcion
        {
            get { return descripcion; }
            set
            {
                if (String.IsNullOrWhiteSpace(value))
                {
                    throw new ArgumentException("La descripción debe estar específicado.");
                }
                descripcion = value;
            }
        }

        public string Color
        {
            get { return color; }
            set
            {
                if (String.IsNullOrWhiteSpace(value))
                {
                    throw new ArgumentException("El color debe estar específicado.");
                }
                color = value;
            }
        }

        public decimal Precio
        {
            get { return precio; }
            set
            {
                if (value < 0)
                {
                    throw new ArgumentException("El precio debe ser positivo.");
                }
                precio = value;
            }
        }

        public decimal Valoracion
        {
            get { return valoracion; }
            set
            {
                if (value < 0 || value > 5)
                {
                    throw new ArgumentException("La valoración debe estar comprendida entre 0 y 5.");
                }
                valoracion = value;
            }
        }

        public string Url_imagen
        {
            get { return url_imagen; }
            set
            {
                if (String.IsNullOrWhiteSpace(value))
                {
                    throw new ArgumentException("La url de la imagen debe estar específicada.");
                }
                url_imagen = value;
            }
        }

        public int Vendido
        {
            get { return vendido; }
            set { vendido = value; }
        }

        public string Vendedor_UName
        {
            get { return vendedor_UName; }
            set
            {
                if (String.IsNullOrWhiteSpace(value))
                {
                    throw new ArgumentException("El nombre del vendedor debe estar específicado debe estar específicado.");
                }
                vendedor_UName = value;
            }
        }

        public ENVehiculo(int vehiculo_id, int marca_id, string modelo, int kilometraje, string color, decimal precio,
            int anyo, string auto_manu, string combustible, string descripcion, decimal valoracion, string url_imagen, int vendido, string vendedor_UName)
        {
            CADVehiculo cadVehiculo = new CADVehiculo();
            /* if (cadVehiculo.ExisteVehiculoId(vehiculo_id))
            {
                throw new InvalidOperationException("El id ya existe.");
            }
            else
            {*/
            Vehiculo_id = vehiculo_id;
            // }
            Marca_id = marca_id;
            Modelo = modelo;
            Kilometraje = kilometraje;
            Color = color;
            Precio = precio;
            Anyo = anyo;
            Auto_Manu = auto_manu;
            Combustible = combustible;
            Descripcion = descripcion;
            Valoracion = valoracion;
            Url_imagen = url_imagen;
            Vendido = vendido;
            Vendedor_UName = vendedor_UName;
        }

    }
}