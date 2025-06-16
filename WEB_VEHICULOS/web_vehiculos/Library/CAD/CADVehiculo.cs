using System;
using System.Data.SqlClient;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Configuration;
using System.Data;

namespace Library
{
    public class CADVehiculo
    {
        private string connectionString;


        public CADVehiculo()
        {
            this.connectionString = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }
        //este lo usa para crear una venta
        public bool Create(ENVehiculo venta, string marca)
        {
            bool success = false;
            SqlConnection conn = new SqlConnection(connectionString);
            try
            {
                conn.Open();

                CADMarcas cadMarcas = new CADMarcas();
                int marcaId = cadMarcas.CheckAndInsertMarca(marca, conn);  // Usar la función desde CADMarcas


                int newVehiculoId = GetNextVehiculoId(conn);


                SqlCommand cmd = new SqlCommand("INSERT INTO vehiculo (vehiculo_id, marca_id, modelo, auto_manu, kilometraje, color, precio, anyo, combustible, descripcion, valoracion, url_imagen, vendido, vendedor_UName) VALUES (@Vehiculo_Id, @Marca_Id, @Modelo, @Auto_Manu, @Kilometraje, @Color, @Precio, @Anyo, @Combustible, @Descripcion, @Valoracion, @Url_Imagen, @Vendido, @Vendedor_UName)", conn);
                cmd.Parameters.AddWithValue("@Vehiculo_Id", newVehiculoId);
                cmd.Parameters.AddWithValue("@Marca_Id", marcaId);
                cmd.Parameters.AddWithValue("@Modelo", venta.Modelo);
                cmd.Parameters.AddWithValue("@Auto_Manu", venta.Auto_Manu);
                cmd.Parameters.AddWithValue("@Kilometraje", venta.Kilometraje);
                cmd.Parameters.AddWithValue("@Color", venta.Color);
                cmd.Parameters.AddWithValue("@Precio", venta.Precio);
                cmd.Parameters.AddWithValue("@Anyo", venta.Anyo);
                cmd.Parameters.AddWithValue("@Combustible", venta.Combustible);
                cmd.Parameters.AddWithValue("@Descripcion", venta.Descripcion);
                cmd.Parameters.AddWithValue("@Valoracion", 0);
                cmd.Parameters.AddWithValue("@Url_Imagen", venta.Url_imagen);
                cmd.Parameters.AddWithValue("@Vendido", 0);
                cmd.Parameters.AddWithValue("@Vendedor_UName", venta.Vendedor_UName);

                cmd.ExecuteNonQuery();
                success = true;
            }
            catch (Exception ex)
            {
                throw new Exception("Error al insertar la venta: " + ex.Message);
            }
            finally
            {
                conn.Close();
            }
            return success;
        }

        // 
        private int GetNextVehiculoId(SqlConnection conn)
        {
            int nextId = 0;

            try
            {
                string query = "SELECT ISNULL(MAX(vehiculo_id), 0) + 1 FROM vehiculo";
                using (SqlCommand cmd = new SqlCommand(query, conn))
                {
                    nextId = (int)cmd.ExecuteScalar();
                }
            }
            catch (Exception ex)
            {
                throw new Exception("Error al obtener el siguiente vehiculo_id: " + ex.Message);
            }

            return nextId;
        }
        public ENVehiculo ReadVehiculo(int vehiculoID)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string sql = "SELECT * FROM vehiculo where vehiculo_id = @VehiculoID";
                using (SqlCommand comando = new SqlCommand(sql, connection))
                {
                    comando.Parameters.AddWithValue("@VehiculoId", vehiculoID);
                    try
                    {
                        connection.Open();
                        using (SqlDataReader dataReader = comando.ExecuteReader())
                        {
                            if (dataReader.Read())
                            {
                                return new ENVehiculo(
                                    Convert.ToInt32(dataReader["vehiculo_id"]),
                                    Convert.ToInt32(dataReader["marca_id"]),
                                    dataReader["modelo"].ToString(),
                                    Convert.ToInt32(dataReader["kilometraje"]),
                                    dataReader["color"].ToString(),
                                    Convert.ToInt32(dataReader["precio"]),
                                    Convert.ToInt32(dataReader["anyo"]),
                                    dataReader["auto_manu"].ToString(),
                                    dataReader["combustible"].ToString(),
                                    dataReader["descripcion"].ToString(),
                                    Convert.ToInt32(dataReader["valoracion"]),
                                    dataReader["url_imagen"].ToString(),
                                    Convert.ToInt32(dataReader["vendido"]),
                                    dataReader["vendedor_UName"].ToString()
                                    );
                            }
                        }
                    }
                    catch(Exception ex)
                    {
                        Console.WriteLine("Error al leer vehiculo: " + ex.Message);
                    }
                    finally
                    {
                        connection.Close();
                    }


                }
            }
            return null;
        }
        public bool UpdateVehiculo(ENVehiculo vehiculo)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string sql = @"
                             UPDATE vehiculo 
                             SET marca = @Marca, modelo = @Modelo, kilonetraje = @Kilometraje, color = @Color, precio = @Precio, anyo = @Anyo, auto_manu = @Auto_Manu, combustible = @Combustible, descripcion = @Descripcion, valoracion = @Valoracion, url_imagen = @Url_imagen, vendido = @Vendido, vendedor_UName = @Vendedor_UName
                             where vehiculo_id = @Vehiculo_Id";
                using (SqlCommand comando = new SqlCommand(sql, connection))
                {
                    comando.Parameters.AddWithValue("@VehiculoId", vehiculo.Vehiculo_id);
                    comando.Parameters.AddWithValue("@Marca", vehiculo.Marca_id);
                    comando.Parameters.AddWithValue("@Modelo", vehiculo.Modelo);
                    comando.Parameters.AddWithValue("@Kilometraje", vehiculo.Kilometraje);
                    comando.Parameters.AddWithValue("@Color", vehiculo.Color);
                    comando.Parameters.AddWithValue("@Precio", vehiculo.Precio);
                    comando.Parameters.AddWithValue("@Anyo", vehiculo.Anyo);
                    comando.Parameters.AddWithValue("@Auto_Manu", vehiculo.Auto_Manu);
                    comando.Parameters.AddWithValue("@Combustible", vehiculo.Combustible);
                    comando.Parameters.AddWithValue("@Descripcion", vehiculo.Descripcion);
                    comando.Parameters.AddWithValue("@Valoracion", vehiculo.Valoracion);
                    comando.Parameters.AddWithValue("@UrlImagen", vehiculo.Url_imagen);
                    comando.Parameters.AddWithValue("@Vendido", vehiculo.Vendido);
                    comando.Parameters.AddWithValue("@Vendedor_UName", vehiculo.Vendedor_UName);

                    try
                    {
                        connection.Open();
                        int updated = comando.ExecuteNonQuery();
                        return updated > 0;

                    }
                    catch (SqlException ex)
                    {
                        Console.WriteLine("Error Sql alctualizar vehículo: " + ex.Message);
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Error al actualizar vehículo: " + ex.Message);
                    }
                    finally
                    {
                        connection.Close();
                    }
                    return false;

                }
            }
        }

        public bool DeleteVehiculo(int vehiculoId)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string sql = "DELETE FROM vehiculo where vehiculo_id = @Vehiculo_Id";
                using (SqlCommand comando = new SqlCommand(sql, connection))
                {
                    comando.Parameters.AddWithValue("@Vehiculo_Id", vehiculoId);
                    try
                    {
                        connection.Open();
                        int deleted = comando.ExecuteNonQuery();
                        return deleted > 0;
                    }
                    catch(Exception ex)
                    {
                        Console.WriteLine("Error al borrar vehículo" + ex.Message);
                    }
                    finally
                    {
                        connection.Close();
                    }
                    return false;

                }
            }
        }
        public bool ExisteVehiculoId(int vehiculoID)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string sql = "SELECT COUNT(1) FROM vehiculo WHERE vehiculo_id = @VehiculoID";
                using (SqlCommand comando = new SqlCommand(sql, connection))
                {
                    comando.Parameters.AddWithValue("@VehiculoID", vehiculoID);
                    try
                    {
                        connection.Open();
                        int exist = (int)comando.ExecuteScalar();
                        return exist > 0;
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Error al verficar si existe vehículo" + ex.Message);
                    }
                    finally
                    {
                        connection.Close();
                    }
                    return true;

                }
            }
        }

        public DataTable ObtenerTodosLosVehiculos()
        {
            DataTable resultados = new DataTable();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = "SELECT v.vehiculo_id, m.marca, v.modelo, v.anyo, v.color, v.kilometraje, v.auto_manu, v.combustible, v.precio, v.valoracion, v.url_imagen, v.vendido FROM vehiculo v LEFT JOIN marcas m ON v.marca_id = m.marca_id";
                SqlCommand command = new SqlCommand(query, connection);

                SqlDataAdapter adapter = new SqlDataAdapter(command);
                adapter.Fill(resultados);
                connection.Close();
            }

            return resultados;
        }

        public DataTable ObtenerVehiculosFiltrados(int marcaId, string modelo, string transmision, string combustible, string precioMin, string precioMax, string kilometrajeMin, string kilometrajeMax, string anyoMin)
        {
            DataTable resultados = new DataTable();

            using (SqlConnection conexion = new SqlConnection(connectionString))
            {
                string query = @"SELECT v.vehiculo_id, m.marca, v.modelo, v.anyo, v.color, v.kilometraje, v.auto_manu, v.combustible, v.precio, v.valoracion, v.url_imagen, v.vendido 
                         FROM vehiculo v 
                         LEFT JOIN marcas m ON v.marca_id = m.marca_id 
                         WHERE 1=1";

                if (marcaId != 0)
                    query += " AND v.marca_id = @marcaId";

                if (!string.IsNullOrEmpty(modelo))
                    query += " AND v.modelo = @modelo";

                if (!string.IsNullOrEmpty(transmision))
                    query += " AND v.auto_manu = @transmision";

                if (!string.IsNullOrEmpty(combustible))
                    query += " AND v.combustible = @combustible";

                if (!string.IsNullOrEmpty(precioMin))
                    query += " AND v.precio >= @precioMin";

                if (!string.IsNullOrEmpty(precioMax))
                    query += " AND v.precio <= @precioMax";

                if (!string.IsNullOrEmpty(kilometrajeMin))
                    query += " AND v.kilometraje >= @kilometrajeMin";

                if (!string.IsNullOrEmpty(kilometrajeMax))
                    query += " AND v.kilometraje <= @kilometrajeMax";

                if (!string.IsNullOrEmpty(anyoMin))
                    query += " AND v.anyo >= @anyoMin";

                SqlCommand command = new SqlCommand(query, conexion);

                if (marcaId != 0)
                    command.Parameters.AddWithValue("@marcaId", marcaId);
                if (!string.IsNullOrEmpty(modelo))
                    command.Parameters.AddWithValue("@modelo", modelo);
                if (!string.IsNullOrEmpty(transmision))
                    command.Parameters.AddWithValue("@transmision", transmision);
                if (!string.IsNullOrEmpty(combustible))
                    command.Parameters.AddWithValue("@combustible", combustible);
                if (!string.IsNullOrEmpty(precioMin))
                    command.Parameters.AddWithValue("@precioMin", precioMin);
                if (!string.IsNullOrEmpty(precioMax))
                    command.Parameters.AddWithValue("@precioMax", precioMax);
                if (!string.IsNullOrEmpty(kilometrajeMin))
                    command.Parameters.AddWithValue("@kilometrajeMin", kilometrajeMin);
                if (!string.IsNullOrEmpty(kilometrajeMax))
                    command.Parameters.AddWithValue("@kilometrajeMax", kilometrajeMax);
                if (!string.IsNullOrEmpty(anyoMin))
                    command.Parameters.AddWithValue("@anyoMin", anyoMin);

                SqlDataAdapter adapter = new SqlDataAdapter(command);
                adapter.Fill(resultados);
            }

            return resultados;
        }


        private bool ExisteUsuario(string username)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string sql = "SELECT COUNT(1) FROM usuarios WHERE username = @username";
                using (SqlCommand comando = new SqlCommand(sql, connection))
                {
                    comando.Parameters.AddWithValue("@username", username);
                    connection.Open();
                    int exist = (int)comando.ExecuteScalar();
                    connection.Close();
                    return exist > 0;
                }
            }
        }
        public int ObtenerTotalValoraciones(int vehiculoId)
        {
            int totalValoraciones = 0;

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string sql = "SELECT COUNT(*) FROM valoraciones WHERE vehiculo_id = @VehiculoId";
                using (SqlCommand comando = new SqlCommand(sql, connection))
                {
                    comando.Parameters.AddWithValue("@VehiculoId", vehiculoId);
                    connection.Open();
                    totalValoraciones = (int)comando.ExecuteScalar();
                }
            }

            return totalValoraciones;
        }
        // este modulo para obtener valoracion actucalizada 
        public bool ActualizarValoracion(int vehiculoId, int nuevaValoracion)
        {
            using (var connection = new SqlConnection(connectionString))
            {
                connection.Open();

                // Obtener la valoración actual desde la tabla vehiculo
                decimal valoracionActual = 0;

                var queryObtenerValoracion = @"
            SELECT valoracion 
            FROM vehiculo 
            WHERE vehiculo_id = @vehiculoId";

                using (var command = new SqlCommand(queryObtenerValoracion, connection))
                {
                    command.Parameters.AddWithValue("@vehiculoId", vehiculoId);
                    var result = command.ExecuteScalar();
                    if (result != DBNull.Value)
                    {
                        valoracionActual = (decimal)result;
                    }
                }
                decimal valoracionPromedio = 0;
                // Calcular la nueva valoración la media 
                if (valoracionActual == 0)
                {
                     valoracionPromedio = nuevaValoracion;
                }
                if (nuevaValoracion == 0)
                {
                    valoracionPromedio = valoracionActual;
                }
                else
                {
                    valoracionPromedio = (valoracionActual + nuevaValoracion) / 2;
                }
                //actualizamos la nueva valor 
                var queryActualizarValoracion = @"
            UPDATE vehiculo 
            SET valoracion = @valoracion 
            WHERE vehiculo_id = @vehiculoId";

                using (var command = new SqlCommand(queryActualizarValoracion, connection))
                {
                    command.Parameters.AddWithValue("@vehiculoId", vehiculoId);
                    command.Parameters.AddWithValue("@valoracion", valoracionPromedio);

                    int rowsAffected = command.ExecuteNonQuery();
                    return rowsAffected > 0;
                }
            }
        }





        public bool ToggleVendido(int vehiculoID)
        {
            try
            {
                using (SqlConnection con = new SqlConnection(connectionString))
                {
                    con.Open();

                    // Obtener el estado actual de 'vendido'
                    string getStatusQuery = "SELECT vendido FROM vehiculo WHERE vehiculo_id = @VehiculoID";
                    SqlCommand getStatusCmd = new SqlCommand(getStatusQuery, con);
                    getStatusCmd.Parameters.AddWithValue("@VehiculoID", vehiculoID);
                    int currentStatus = (int)getStatusCmd.ExecuteScalar();

                    // Invertir el estado de 'vendido'
                    int newStatus = currentStatus == 1 ? 0 : 1;

                    // Actualizar el estado de 'vendido'
                    string updateQuery = "UPDATE vehiculo SET vendido = @NewStatus WHERE vehiculo_id = @VehiculoID";
                    SqlCommand updateCmd = new SqlCommand(updateQuery, con);
                    updateCmd.Parameters.AddWithValue("@NewStatus", newStatus);
                    updateCmd.Parameters.AddWithValue("@VehiculoID", vehiculoID);

                    int rowsAffected = updateCmd.ExecuteNonQuery();
                    return rowsAffected > 0;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error: " + ex.Message);
                return false;
            }
        }

        public DataTable GetVehiculo()
        {
            try
            {
                using (SqlConnection con = new SqlConnection(connectionString))
                {
                    con.Open();
                    string query = "SELECT vehiculo_id, marca_id, modelo, precio, CASE WHEN vendido = 1 THEN 'Si' ELSE 'No' END AS vendido FROM vehiculo";
                    SqlDataAdapter da = new SqlDataAdapter(query, con);
                    DataTable dt = new DataTable();
                    da.Fill(dt);
                    return dt;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error: " + ex.Message);
                return null;
            }
        }


    }

}