using System;
using System.Data;
using System.Data.SqlClient;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Library.EN;

namespace Library
{
    public class CADConsejos
    {
        private string connectionString;



        public CADConsejos()
        {
            connectionString = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }
        public  List<ENConsejos> GetConsejos(string categoria)
        {
            List<ENConsejos> consejos = new List<ENConsejos>();

            using (SqlConnection conection = new SqlConnection(connectionString))
            {
                try
                {
                    conection.Open();
                    string sql = "SELECT consejo_id, categoria, pregunta, respuesta FROM consejos";

                    using (SqlCommand comando = new SqlCommand(sql, conection))
                    {
                        using (SqlDataReader reader = comando.ExecuteReader())
                        {
                            while (reader.Read())
                            {


                                ENConsejos consejo = new ENConsejos(
                                    Convert.ToInt32(reader["consejo_id"]),
                                    reader["categoria"].ToString(),
                                    reader["pregunta"].ToString(),
                                    reader["respuesta"].ToString());

                                consejos.Add(consejo);
                            }
                        }
                    }
                    return consejos;
                }
                catch(Exception ex)
                {
                    Console.WriteLine("Erro al leer los consejos de la base de datos: " + ex.Message);
                }
                finally
                {
                    conection.Close();
                }
                return consejos;

            }
        }
    }
}

