using System;
using System.Data;
using System.Data.SqlClient;

namespace Library
{
    public class CADMetodoPago
    {
        private string connectionString;

        public CADMetodoPago()
        {
            connectionString = System.Configuration.ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }

        public void PagarCarritoCompra(string username)
        {
            DataSet dataset = new DataSet();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                try
                {
                    connection.Open();
                    string query = @"UPDATE vehiculo
                                        SET vendido = 0
                                        WHERE vehiculo_id IN (
                                            SELECT v.vehiculo_id
                                            FROM vehiculo v
                                            JOIN lineacarrito lc ON lc.vehiculo_id = v.vehiculo_id 
                                            JOIN carrito c ON c.carrito_id = lc.carrito_id
                                            JOIN usuarios u ON u.username = c.usuario_UName
                                            JOIN marcas m ON m.marca_id = v.marca_id
                                            WHERE u.username = @username);";

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
        }

        public void PagarIdVehiculo(int idVehiculo)
        {
            DataSet dataset = new DataSet();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                try
                {
                    connection.Open();
                    string query = @"UPDATE vehiculo SET vendido = 1 WHERE vehiculo_id = @VehiculoID";

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
        }

        // Método para actualizar el método de pago
        public void ActualizarMetodoPago(string numeroTarjeta, string cvv, int mesCaducidad, int anoCaducidad, string usuarioNombre)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                connection.Open();
                SqlTransaction transaction = connection.BeginTransaction();

                try
                {
                    string updateQuery = @"
                        UPDATE metodos_pago 
                        SET numTarjeta = @numTarjeta, 
                            cvv = @cvv, 
                            mes_cad = @mes_cad, 
                            anyo_cad = @anyo_cad
                        WHERE usuario = @usuario";

                    using (SqlCommand command = new SqlCommand(updateQuery, connection, transaction))
                    {
                        command.Parameters.AddWithValue("@numTarjeta", numeroTarjeta);
                        command.Parameters.AddWithValue("@cvv", cvv);
                        command.Parameters.AddWithValue("@mes_cad", mesCaducidad);
                        command.Parameters.AddWithValue("@anyo_cad", anoCaducidad);
                        command.Parameters.AddWithValue("@usuario", usuarioNombre);

                        command.ExecuteNonQuery();
                    }

                    transaction.Commit();
                }
                catch (Exception)
                {
                    transaction.Rollback();
                    throw;
                }
            }
        }

        // Método para actualizar el vehículo
        public bool ActualizarVehiculo(string vehiculoId)
        {
            bool vehiculoActualizado = false;

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                connection.Open();
                SqlTransaction transaction = connection.BeginTransaction();

                try
                {
                    // Verificar si el vehículo está disponible para ser vendido (estado = 0)
                    string selectQuery = @"
                        SELECT vendido
                        FROM vehiculo
                        WHERE vehiculo_id = @vehiculo_id";

                    string updateQuery = @"
                        UPDATE vehiculo 
                        SET vendido = 1 
                        WHERE vehiculo_id = @vehiculo_id AND estado = 0";

                    using (SqlCommand selectCommand = new SqlCommand(selectQuery, connection, transaction))
                    {
                        selectCommand.Parameters.AddWithValue("@vehiculo_id", vehiculoId);

                        int estado = (int)selectCommand.ExecuteScalar();

                        if (estado == 0)
                        {
                            using (SqlCommand updateCommand = new SqlCommand(updateQuery, connection, transaction))
                            {
                                updateCommand.Parameters.AddWithValue("@vehiculo_id", vehiculoId);
                                updateCommand.ExecuteNonQuery();
                            }

                            vehiculoActualizado = true;
                        }
                    }

                    transaction.Commit();
                }
                catch (Exception)
                {
                    transaction.Rollback();
                    throw;
                }
            }

            return vehiculoActualizado;
        }
    }
}






