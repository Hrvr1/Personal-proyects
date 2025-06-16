using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    public class ENConsejos
    {
        private int id;
        private string categoria_consejo;
        private string pregunta_consejo;
        private string respuesta_consejo;

        public int Id_consejo
        {
            get { return id; }
            set
            {
                id = value;
            }
        }
        public string Categoria_consejo
        {
            get { return categoria_consejo; }
            set
            {
                categoria_consejo = value;
            }
        }
        public string Pregunta_consejo
        {
            get { return pregunta_consejo; }
            set { pregunta_consejo = value; }
        }
        public string Respuesta_consejo
        {
            get { return respuesta_consejo; }
            set { respuesta_consejo = value; }
        }
        public ENConsejos(int id, string categoria, string pregunta, string respuesta)
        {
            Id_consejo = id;
            Categoria_consejo = categoria;
            Pregunta_consejo = pregunta;
            Respuesta_consejo = respuesta; 
        }
    }
}
