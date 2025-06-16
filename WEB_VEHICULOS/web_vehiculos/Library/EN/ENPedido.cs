using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    public class ENPedido
    {
        private int pedido_id;
        private int vehiculo_id;
        private string comprador_name;
        private string vendedor_name;
        private DateTime fecha_pedido;
        private float importe;

        public int Pedido_id
        {
            get { return pedido_id; }
            set { pedido_id = value; }
        }

        public int Vehiculo_id
        {
            get { return vehiculo_id; }
            set { vehiculo_id = value; }
        }

        public string Comprador_name
        {
            get { return comprador_name; }
            set { comprador_name = value; }
        }

        public string Vendedor_name
        {
            get { return vendedor_name; }
            set { vendedor_name = value; }
        }

        public DateTime Fecha_pedido
        {
            get { return fecha_pedido; }
            set { fecha_pedido = value; }
        }

        public float Importe
        {
            get { return importe; }
            set { importe = value; }
        }
    }
}
