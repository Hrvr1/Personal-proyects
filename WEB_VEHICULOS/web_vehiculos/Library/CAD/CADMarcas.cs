using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;

namespace Library
{
    public class CADMarcas
    {
        private string connectionString;

        public CADMarcas()
        {
            connectionString = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }

        public DataTable ObtenerMarcasDesdeBaseDeDatos()
        {
            DataTable marcas = new DataTable();

            try
            {
                using (SqlConnection connection = new SqlConnection(connectionString))
                {
                    string query = "SELECT marca_id, marca FROM marcas";
                    SqlCommand command = new SqlCommand(query, connection);

                    SqlDataAdapter adapter = new SqlDataAdapter(command);
                    adapter.Fill(marcas);
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al obtener las marcas desde la base de datos: " + ex.Message);
            }

            return marcas;
        }
        public string ObtenerMarca(int id)
        {
            string marca = null;

            try
            {
                string query = "SELECT marca FROM marcas WHERE marca_id = @id";

                using (SqlConnection connection = new SqlConnection(connectionString))
                {
                    using (SqlCommand command = new SqlCommand(query, connection))
                    {
                        command.Parameters.AddWithValue("@id", id);
                        connection.Open();
                        using (SqlDataReader reader = command.ExecuteReader())
                        {
                            if (reader.Read())
                            {
                                marca = reader["marca"].ToString();
                            }
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error al obtener la marca desde la base de datos: " + ex.Message);
            }

            return marca;
        }
        public int CheckAndInsertMarca(string marca, SqlConnection conn)
        {
            int marcaId = 0;

            try
            {

                string checkQuery = "SELECT marca_id FROM marcas WHERE marca = @marca";
                using (SqlCommand checkCommand = new SqlCommand(checkQuery, conn))
                {
                    checkCommand.Parameters.AddWithValue("@marca", marca);
                    object result = checkCommand.ExecuteScalar();

                    if (result != null)
                    {
                        marcaId = Convert.ToInt32(result);
                    }
                    else
                    {

                        string maxIdQuery = "SELECT ISNULL(MAX(marca_id), 0) + 1 FROM marcas";
                        using (SqlCommand maxIdCommand = new SqlCommand(maxIdQuery, conn))
                        {
                            marcaId = (int)maxIdCommand.ExecuteScalar();
                        }


                        string insertQuery = "INSERT INTO marcas (marca_id, marca) VALUES (@marca_id, @marca)";
                        using (SqlCommand insertCommand = new SqlCommand(insertQuery, conn))
                        {
                            insertCommand.Parameters.AddWithValue("@marca_id", marcaId);
                            insertCommand.Parameters.AddWithValue("@marca", marca);
                            insertCommand.ExecuteNonQuery();
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                throw new Exception("Error al comprobar e insertar la marca: " + ex.Message);
            }

            return marcaId;
        }
    }
}
