using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    public class ENListaFavorito
    {
        private int lista_id;
        private int vehiculo_id;
        private string usuario_name;

        public int Lista_id
        {
            get { return lista_id; }
            set { lista_id = value; }
        }

        public int Vehiculo_id
        {
            get { return vehiculo_id; }
            set { vehiculo_id = value; }
        }

        public string Usuario_name
        {
            get { return usuario_name; }
            set { usuario_name = value; }
        }

        public ENListaFavorito(string usuario_name)
        {
            this.usuario_name = usuario_name;
        }

        public DataSet show()
        {
            CADListaFavorito cadlistafavorito = new CADListaFavorito();
            return cadlistafavorito.Show(usuario_name);
        }

        public bool AddFavoriteCar(int vehiculo_id)
        {
            CADListaFavorito cadlistafavorito = new CADListaFavorito();
            return cadlistafavorito.AddFavoriteCar(usuario_name, vehiculo_id);
        }

        public bool RemoveFavoriteCar(int vehiculo_id)
        {
            CADListaFavorito cadlistafavorito = new CADListaFavorito();
            return cadlistafavorito.RemoveFavoriteCar(usuario_name, vehiculo_id);
        }

        public bool deleteAll()
        {
            CADListaFavorito cadlistafavorito = new CADListaFavorito();
            return cadlistafavorito.DeleteAll(usuario_name);
        }
    }
}
