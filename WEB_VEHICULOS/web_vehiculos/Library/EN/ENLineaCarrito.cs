namespace Library
{
    public class ENLineaCarrito
    {
        private int carrito_id;
        private int vehiculo_id;
        private decimal importe;

        public int Carrito_id
        {
            get { return carrito_id; }
            set { carrito_id = value; }
        }

        public int Vehiculo_id
        {
            get { return vehiculo_id; }
            set { vehiculo_id = value; }
        }

        public decimal Importe
        {
            get { return importe; }
            set { importe = value; }
        }

        public ENLineaCarrito()
        {

        }

        public ENLineaCarrito(int carrito_id, int vehiculo_id, decimal importe)
        {
            this.carrito_id = carrito_id;
            this.vehiculo_id = vehiculo_id;
            this.importe = importe;
        }

        public bool EliminarLineaCarritoPorId(int lineaCarritoId)
        {
            CADLineaCarrito cadLineaCarrito = new CADLineaCarrito();
            return cadLineaCarrito.EliminarLineaCarritoPorId(lineaCarritoId);
        }

        public bool AddLineaCarrito(int carritoId, int vehiculoId)
        {
            CADLineaCarrito cadLineaCarrito = new CADLineaCarrito();
            return cadLineaCarrito.AddLineaCarrito(carritoId, vehiculoId);
        }
    }
}
