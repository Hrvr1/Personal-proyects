using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    public class ENMetodoPago
    {
        private int metodo_pago_id;
        private string usuario_nombre;
        private enum tipo_pago { tarjeta_debito, tarjeta_creadito, paypal, transferencia };
        private int numero_tarjeta;
        private DateTime fecha_caducidad;
        private int codigo_seguridad;

        public int Metodo_pago_id
        {
            get { return metodo_pago_id; }
            set { metodo_pago_id = value; }
        }

        public string Usuario_nombre
        {
            get { return usuario_nombre; }
            set { usuario_nombre = value; }
        }

        public int Numero_tarjeta
{
            get { return numero_tarjeta; }
            set { numero_tarjeta = value; }
        }

        public DateTime Fecha_caducidad
        {
            get { return fecha_caducidad; }
            set { fecha_caducidad = value; }
        }

        public int Codigo_seguridad
        {
            get { return codigo_seguridad; }
            set { codigo_seguridad = value; }
        }

    }
}
