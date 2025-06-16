using Library.EN;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{    
    internal class CADContacto   
    {
        private string connectionString; 

        public CADContacto()
        {
            
            connectionString = "Tu_Cadena_De_Conexion_Aquí";
        }

        public bool crearContacto(ENContacto contacto)
        {
            throw new NotImplementedException();
        }

        public ENContacto leerContacto(int id)
        {
            
            throw new NotImplementedException();
        }

        public bool editarContacto(ENContacto contacto)
        {
            throw new NotImplementedException();
        }

        public bool eliminarContacto(int id)
        {
            
            throw new NotImplementedException();
        }

        public List<ENContacto> obtenerTodosLosContactos()
        {
            
            throw new NotImplementedException();
        }
    }
}  
