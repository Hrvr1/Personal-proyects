using System;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;

namespace Library
{
    public class CADLineaCarrito
    {
        private string connectionString;

        public CADLineaCarrito()
        {
            connectionString = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }

        public bool EliminarLineaCarritoPorId(int lineaCarritoId)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"DELETE FROM lineacarrito WHERE linea_carrito_id = @lineaCarritoId";

                SqlCommand command = new SqlCommand(query, connection);
                command.Parameters.AddWithValue("@lineaCarritoId", lineaCarritoId);

                connection.Open();

                try
                {
                    command.ExecuteNonQuery();
                    return true; 
                }
                catch (SqlException ex)
                {
                    Console.WriteLine("Error al eliminar el elemento del carrito: " + ex.Message);
                    return false; 
                }
                finally
                {
                    connection.Close();
                }
            }
        }

        public bool AddLineaCarrito(int carritoId, int vehiculoId)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"INSERT INTO lineacarrito (carrito_id, vehiculo_id) VALUES (@carritoId, @vehiculoId)";

                SqlCommand command = new SqlCommand(query, connection);
                command.Parameters.AddWithValue("@carritoId", carritoId);
                command.Parameters.AddWithValue("@vehiculoId", vehiculoId);

                connection.Open();

                try
                {
                    command.ExecuteNonQuery();
                    return true; 
                }
                catch (SqlException ex)
                {
                    Console.WriteLine("Error al agregar el elemento al carrito: " + ex.Message);
                    return false; 
                }
                finally
                {
                    connection.Close();
                }
            }
        }
    }
}
