using System;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;

namespace Library
{
    public class CADCarrito
    {
        private readonly string connectionString;

        public CADCarrito()
        {
            connectionString = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }

        public DataSet Show(string usuario)
        {
            DataSet dataset = new DataSet();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                try
                {
                    connection.Open();
                    string query = @"
                            SELECT lc.linea_carrito_id, lc.carrito_id, lc.vehiculo_id, v.precio,
                            v.modelo, m.marca, v.url_imagen, v.auto_manu, v.combustible, v.kilometraje
                            FROM lineacarrito lc
                            INNER JOIN vehiculo v ON lc.vehiculo_id = v.vehiculo_id
                            INNER JOIN carrito c ON lc.carrito_id = c.carrito_id
                            INNER JOIN marcas m ON m.marca_id = v.marca_id
                            WHERE c.usuario_UName = @usuario";
                    SqlCommand command = new SqlCommand(query, connection);
                    command.Parameters.AddWithValue("@usuario", usuario);

                    SqlDataAdapter adapter = new SqlDataAdapter(command);
                    DataTable dataTable = new DataTable();
                    adapter.Fill(dataTable);

                    if (dataTable.Columns.Contains("precio_unitario"))
                        dataTable.Columns["precio_unitario"].ColumnName = "Importe";

                    dataset.Tables.Add(dataTable);
                }
                catch (SqlException ex)
                {
                    Console.WriteLine("SQL Error al mostrar carrito: " + ex.Message);
                }
                catch (Exception ex)
                {
                    Console.WriteLine("Error al mostrar carrito: " + ex.Message);
                }
            }
            return dataset;
        }

        public bool AddCarrito(string usuario, int vehiculoId)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"
                INSERT INTO lineacarrito (carrito_id, usuario_UName, vehiculo_id, importe)
                SELECT 
                    c.carrito_id,
                    @usuario,
                    @vehiculoId,
                    v.precio
                FROM 
                    carrito c
                JOIN
                    vehiculo v ON v.vehiculo_id = @vehiculoId
                WHERE 
                    c.usuario_UName = @usuario";

                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    command.Parameters.AddWithValue("@usuario", usuario);
                    command.Parameters.AddWithValue("@vehiculoId", vehiculoId);

                    try
                    {
                        connection.Open();
                        int result = command.ExecuteNonQuery();
                        return true;
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Error adding item to shopping cart: " + ex.Message);
                        return false;
                    }
                }
            }
        }

        public bool CheckCarritoUser(string usuario)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"
                SELECT carrito_id, usuario_UName FROM carrito WHERE usuario_UName = @usuario";

                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    command.Parameters.AddWithValue("@usuario", usuario);

                    try
                    {
                        connection.Open();
                        int result = command.ExecuteNonQuery();

                        if(result > 0)
                        {
                            return true;
                        }

                        return false;
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Error adding new user to shopping cart: " + ex.Message);
                        return false;
                    }
                }
            }
        }

        public bool AddCarritoNewUser(string usuario)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"
                IF NOT EXISTS (SELECT 1 FROM carrito WHERE usuario_UName = @usuario)
                BEGIN
                    INSERT INTO carrito (usuario_UName)
                    VALUES (@usuario);
                    SELECT 1; -- Indicates successful insertion
                END
                ELSE
                BEGIN
                    SELECT 0; -- Indicates user already exists
                END";

                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    command.Parameters.AddWithValue("@usuario", usuario);

                    try
                    {
                        connection.Open();
                        int result = command.ExecuteNonQuery();
                        return true;
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Error adding new user to shopping cart: " + ex.Message);
                        return false;
                    }
                }
            }
        }

        public bool DeleteOne(string usuario, int lineaPedidoId)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"DELETE FROM lineacarrito WHERE usuario_UName = @usuario AND linea_pedido_id = @lineaPedidoId";

                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    command.Parameters.AddWithValue("@usuario", usuario);
                    command.Parameters.AddWithValue("@lineaPedidoId", lineaPedidoId);

                    try
                    {
                        connection.Open();
                        command.ExecuteNonQuery();
                        return true;
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Error deleting item from shopping cart: " + ex.Message);
                        return false;
                    }
                }
            }
        }

        public bool DeleteAll(string usuario)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"DELETE FROM lineacarrito WHERE usuario_UName = @usuario";

                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    command.Parameters.AddWithValue("@usuario", usuario);

                    try
                    {
                        connection.Open();
                        command.ExecuteNonQuery();
                        return true;
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Error deleting all items from shopping cart: " + ex.Message);
                        return false;
                    }
                }
            }
        }

        public decimal PrecioTotal(string usuario)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"
                    SELECT SUM(v.precio) AS TotalPrice
                    FROM lineacarrito lc
                    INNER JOIN vehiculo v ON lc.vehiculo_id = v.vehiculo_id
                    INNER JOIN carrito c ON lc.carrito_id = c.carrito_id
                    WHERE c.usuario_UName = @usuario";

                SqlCommand command = new SqlCommand(query, connection);
                command.Parameters.AddWithValue("@usuario", usuario);

                try
                {
                    connection.Open();
                    object result = command.ExecuteScalar();
                    decimal totalPrice = result != DBNull.Value ? Convert.ToDecimal(result) : 0;

                    if(totalPrice < 0)
                    {
                        return 0;
                    }

                    return totalPrice;
                }
                catch (Exception ex)
                {
                    Console.WriteLine("Error calculating total price: " + ex.Message);
                }
            }
            return 0;
        }

    }
}
