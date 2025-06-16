using System;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;

namespace Library
{
    public class CADPedido
    {
        private readonly string connectionString;

        public CADPedido()
        {
            connectionString = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }

        // Método para agregar un pedido
        public bool AddPedido(string compradorUName, string vendedorUName, DateTime fechaPedido, float total)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"
                    INSERT INTO pedido (comprador_UName, vendedor_UName, fecha_pedido, total)
                    VALUES (@compradorUName, @vendedorUName, @fechaPedido, @total)";

                SqlCommand command = new SqlCommand(query, connection);
                command.Parameters.AddWithValue("@compradorUName", compradorUName);
                command.Parameters.AddWithValue("@vendedorUName", vendedorUName);
                command.Parameters.AddWithValue("@fechaPedido", fechaPedido);
                command.Parameters.AddWithValue("@total", total);

                try
                {
                    connection.Open();
                    command.ExecuteNonQuery();
                    return true;
                }
                catch (SqlException ex)
                {
                    Console.WriteLine("Error al agregar el pedido: " + ex.Message);
                    return false;
                }
                finally
                {
                    connection.Close();
                }
            }
        }

        public DataSet ObtenerByCarritoCompra(string username)
        {
            DataSet dataset = new DataSet();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                try
                {
                    connection.Open();
                    string query = @"SELECT * FROM  vehiculo v 
                                    JOIN lineacarrito lc ON lc.vehiculo_id = v.vehiculo_id 
                                    JOIN carrito c ON c.carrito_id = lc.carrito_id
                                    JOIN usuarios u ON u.username = c.usuario_UName
                                    JOIN marcas m ON m.marca_id = v.marca_id
                                    WHERE u.username = @username";

                    SqlCommand command = new SqlCommand(query, connection);
                    command.Parameters.AddWithValue("@username", username);

                    SqlDataAdapter adapter = new SqlDataAdapter(command);
                    DataTable dataTable = new DataTable();
                    adapter.Fill(dataTable);

                    dataset.Tables.Add(dataTable);
                }
                catch (SqlException ex)
                {
                    Console.WriteLine("SQL Error al mostrar favoritos: " + ex.Message);
                }
                catch (Exception ex)
                {
                    Console.WriteLine("Error al mostrar favoritos: " + ex.Message);
                }
                finally
                {
                    connection.Close();
                }
            }
            return dataset;
        }

        public DataSet ObtenerByIdVehiculo(int idVehiculo)
        {
            DataSet dataset = new DataSet();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                try
                {
                    connection.Open();
                    string query = @"SELECT * FROM vehiculo v JOIN marcas m ON m.marca_id = v.marca_id where v.vehiculo_id = @VehiculoID";

                    SqlCommand command = new SqlCommand(query, connection);
                    command.Parameters.AddWithValue("@VehiculoID", idVehiculo);

                    SqlDataAdapter adapter = new SqlDataAdapter(command);
                    DataTable dataTable = new DataTable();
                    adapter.Fill(dataTable);

                    dataset.Tables.Add(dataTable);
                }
                catch (SqlException ex)
                {
                    Console.WriteLine("SQL Error al mostrar favoritos: " + ex.Message);
                }
                catch (Exception ex)
                {
                    Console.WriteLine("Error al mostrar favoritos: " + ex.Message);
                }
                finally
                {
                    connection.Close();
                }
            }
            return dataset;
        }
    }
}

