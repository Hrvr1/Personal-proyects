using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    public class ENLineaPedido
    {
        private int linea_pedido_id;
        private int pedido_id;
        private int vehiculo_id;
        private float importe;

        public int Linea_Pedido_ID
        {
            get { return linea_pedido_id; }
            set { linea_pedido_id = value; }
        }

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

        public float Importe
        {
            get { return importe; }
            set { importe = value; }

        }
    }
}
