using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Configuration;
using System.Data.SqlClient;
using Library.EN;
using System.Data;

namespace Library.CAD
{
    public class CADUsuario
    {
        private string constring { get; set; }

        public CADUsuario()
        {

            constring = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }

        public bool CreateUsuario(ENUsuario usu)
        {
            try
            {
                using (SqlConnection con = new SqlConnection(constring))
                {
                    con.Open();
                    string query = "INSERT INTO usuarios (username, nombre, apellidos, telefono, contrasenya, calle, localidad, provincia, codigo_postal, email, admin) " +
                                   "VALUES (@Username, @Nombre, @Apellidos, @Telefono, @Contrasenya, @Calle, @Localidad, @Provincia, @Codigo_Postal, @Email, @Admin)";
                    SqlCommand cmd = new SqlCommand(query, con);
                    cmd.Parameters.AddWithValue("@Username", usu.Username);
                    cmd.Parameters.AddWithValue("@Nombre", usu.Nombre);
                    cmd.Parameters.AddWithValue("@Apellidos", usu.Apellidos);
                    cmd.Parameters.AddWithValue("@Telefono", usu.Telefono);
                    cmd.Parameters.AddWithValue("@Contrasenya", usu.Contrasenya);
                    cmd.Parameters.AddWithValue("@Calle", usu.Calle);
                    cmd.Parameters.AddWithValue("@Localidad", usu.Localidad);
                    cmd.Parameters.AddWithValue("@Provincia", usu.Provincia);
                    cmd.Parameters.AddWithValue("@Codigo_Postal", usu.Codigo_Postal);
                    cmd.Parameters.AddWithValue("@Email", usu.Email);
                    cmd.Parameters.AddWithValue("@Admin", usu.Admin ? 1 : 0);

                    int rowsAffected = cmd.ExecuteNonQuery();
                    return rowsAffected > 0;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error: " + ex.Message);
                return false;
            }
        }


        public bool UpdateUsuario(ENUsuario usu)
        {
            try
            {
                using (SqlConnection con = new SqlConnection(constring))
                {
                    con.Open();
                    string query = "UPDATE usuarios " +
                                   "SET nombre = @Nombre, " +
                                   "apellidos = @Apellidos, " +
                                   "telefono = @Telefono, " +
                                   "contrasenya = @Contrasenya, " +
                                   "calle = @Calle, " +
                                   "localidad = @Localidad, " +
                                   "provincia = @Provincia, " +
                                   "codigo_postal = @Codigo_Postal, " +
                                   "email = @Email, " +
                                   "admin = @Admin " +
                                   "WHERE username = @Username";
                    SqlCommand cmd = new SqlCommand(query, con);
                    cmd.Parameters.AddWithValue("@Nombre", usu.Nombre);
                    cmd.Parameters.AddWithValue("@Apellidos", usu.Apellidos);
                    cmd.Parameters.AddWithValue("@Telefono", usu.Telefono);
                    cmd.Parameters.AddWithValue("@Contrasenya", usu.Contrasenya);
                    cmd.Parameters.AddWithValue("@Calle", usu.Calle);
                    cmd.Parameters.AddWithValue("@Localidad", usu.Localidad);
                    cmd.Parameters.AddWithValue("@Provincia", usu.Provincia);
                    cmd.Parameters.AddWithValue("@Codigo_Postal", usu.Codigo_Postal);
                    cmd.Parameters.AddWithValue("@Email", usu.Email);
                    cmd.Parameters.AddWithValue("@Admin", usu.Admin ? 1 : 0);
                    cmd.Parameters.AddWithValue("@Username", usu.Username);

                    Console.WriteLine("Ejecutando consulta de actualización: " + query);
                    Console.WriteLine("Parámetros:");
                    Console.WriteLine("@Nombre = " + usu.Nombre);
                    Console.WriteLine("@Apellidos = " + usu.Apellidos);
                    Console.WriteLine("@Telefono = " + usu.Telefono);
                    Console.WriteLine("@Calle = " + usu.Calle);
                    Console.WriteLine("@Codigo_Postal = " + usu.Codigo_Postal);
                    Console.WriteLine("@Localidad = " + usu.Localidad);
                    Console.WriteLine("@Provincia = " + usu.Provincia);
                    Console.WriteLine("@Email = " + usu.Email);
                    Console.WriteLine("@Username = " + usu.Username);
                    int rowsAffected = cmd.ExecuteNonQuery();
                    return rowsAffected > 0;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error: " + ex.Message);
                return false;
            }
        }



        public bool FindUsuarioByUsername(ENUsuario usuario)
        {
            try
            {
                using (SqlConnection con = new SqlConnection(constring))
                {
                    con.Open();
                    string query = "SELECT * FROM usuarios WHERE username = @Username";
                    SqlCommand cmd = new SqlCommand(query, con);
                    cmd.Parameters.AddWithValue("@Username", usuario.Username);

                    using (SqlDataReader reader = cmd.ExecuteReader())
                    {
                        if (reader.Read())
                        {
                            usuario.Username = reader["username"].ToString();
                            usuario.Nombre = reader["nombre"].ToString();
                            usuario.Apellidos = reader["apellidos"].ToString();
                            usuario.Telefono = reader["telefono"].ToString();
                            usuario.Contrasenya = reader["contrasenya"].ToString();
                            usuario.Calle = reader["calle"].ToString();
                            usuario.Localidad = reader["localidad"].ToString();
                            usuario.Provincia = reader["provincia"].ToString();
                            usuario.Codigo_Postal = reader["codigo_postal"].ToString();
                            usuario.Email = reader["email"].ToString();
                            usuario.Admin = Convert.ToBoolean(reader["admin"]);

                            // Mensaje de depuración
                            System.Diagnostics.Debug.WriteLine("Usuario encontrado en la base de datos: " + usuario.Username + ", Admin: " + usuario.Admin);
                            return true;
                        }
                        else
                        {
                            System.Diagnostics.Debug.WriteLine("Usuario no encontrado en la base de datos: " + usuario.Username);
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                System.Diagnostics.Debug.WriteLine("Error: " + ex.Message);
            }
            return false;
        }


        public bool FindUsuarioByTelefono(ENUsuario nuevoUsuario)
        {
            {
                using (SqlConnection conn = new SqlConnection(constring))
                {
                    string query = "SELECT COUNT(*) FROM Usuarios WHERE Telefono = @Telefono";
                    SqlCommand cmd = new SqlCommand(query, conn);
                    cmd.Parameters.AddWithValue("@Telefono", nuevoUsuario.Telefono);

                    try
                    {
                        conn.Open();
                        int count = (int)cmd.ExecuteScalar();
                        return count > 0;
                    }
                    catch (Exception ex)
                    {
                        throw new Exception("Error al buscar el usuario por teléfono", ex);
                    }
                }
            }
        }

        public bool ChangePassword(ENUsuario usu)
        {
            try
            {
                using (SqlConnection con = new SqlConnection(constring))
                {
                    con.Open();
                    string query = "UPDATE usuarios " +
                                   "SET contrasenya = @Contrasenya " +
                                   "WHERE username = @Username";
                    SqlCommand cmd = new SqlCommand(query, con);
                    cmd.Parameters.AddWithValue("@Contrasenya", usu.Contrasenya);
                    cmd.Parameters.AddWithValue("@Username", usu.Username);

                    int rowsAffected = cmd.ExecuteNonQuery();
                    return rowsAffected > 0;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error: " + ex.Message);
                return false;
            }
        }
        public bool DeleteUsuario(string username, out string errorMessage)
        {
            errorMessage = string.Empty;
            List<string> deletedTables = new List<string>();

            using (SqlConnection connection = new SqlConnection(constring))
            {
                connection.Open();

                // Comienza la transacción
                SqlTransaction transaction = connection.BeginTransaction();

                try
                {
                    // Borrar referencias en lista_favoritos para los vehículos del usuario
                    string deleteFavoritesVehiclesQuery = "DELETE FROM lista_favoritos WHERE vehiculo_id IN (SELECT vehiculo_id FROM vehiculo WHERE vendedor_UName = @username)";
                    using (SqlCommand deleteFavoritesVehiclesCommand = new SqlCommand(deleteFavoritesVehiclesQuery, connection, transaction))
                    {
                        deleteFavoritesVehiclesCommand.Parameters.AddWithValue("@username", username);
                        deleteFavoritesVehiclesCommand.ExecuteNonQuery();
                        deletedTables.Add("lista_favoritos (vehiculo references)");
                    }

                    // Borrar favoritos del usuario
                    string deleteFavoritesQuery = "DELETE FROM lista_favoritos WHERE usuario_UName = @username";
                    using (SqlCommand deleteFavoritesCommand = new SqlCommand(deleteFavoritesQuery, connection, transaction))
                    {
                        deleteFavoritesCommand.Parameters.AddWithValue("@username", username);
                        deleteFavoritesCommand.ExecuteNonQuery();
                        deletedTables.Add("lista_favoritos");
                    }

                    // Borrar las líneas de bandeja de notificación del usuario
                    string deleteLineaBandejaNotificacionQuery = "DELETE FROM lineaBandejaNotificacion WHERE notificacion_id IN (SELECT notificacion_id FROM bandejaNotificacion WHERE usuario_UName = @username)";
                    using (SqlCommand deleteLineaBandejaNotificacionCommand = new SqlCommand(deleteLineaBandejaNotificacionQuery, connection, transaction))
                    {
                        deleteLineaBandejaNotificacionCommand.Parameters.AddWithValue("@username", username);
                        deleteLineaBandejaNotificacionCommand.ExecuteNonQuery();
                        deletedTables.Add("lineaBandejaNotificacion");
                    }

                    // Borrar la bandeja de notificación del usuario
                    string deleteBandejaNotificacionQuery = "DELETE FROM bandejaNotificacion WHERE usuario_UName = @username";
                    using (SqlCommand deleteBandejaNotificacionCommand = new SqlCommand(deleteBandejaNotificacionQuery, connection, transaction))
                    {
                        deleteBandejaNotificacionCommand.Parameters.AddWithValue("@username", username);
                        deleteBandejaNotificacionCommand.ExecuteNonQuery();
                        deletedTables.Add("bandejaNotificacion");
                    }

                    // Borrar métodos de pago del usuario
                    string deletePaymentMethodsQuery = "DELETE FROM metodos_pago WHERE usuario = @username";
                    using (SqlCommand deletePaymentMethodsCommand = new SqlCommand(deletePaymentMethodsQuery, connection, transaction))
                    {
                        deletePaymentMethodsCommand.Parameters.AddWithValue("@username", username);
                        deletePaymentMethodsCommand.ExecuteNonQuery();
                        deletedTables.Add("metodos_pago");
                    }

                    // Borrar las líneas de carrito del usuario
                    string deleteLineaCarritoQuery = "DELETE FROM lineacarrito WHERE usuario_UName = @username";
                    using (SqlCommand deleteLineaCarritoCommand = new SqlCommand(deleteLineaCarritoQuery, connection, transaction))
                    {
                        deleteLineaCarritoCommand.Parameters.AddWithValue("@username", username);
                        deleteLineaCarritoCommand.ExecuteNonQuery();
                        deletedTables.Add("lineacarrito");
                    }

                    // Borrar el carrito del usuario
                    string deleteCartQuery = "DELETE FROM carrito WHERE usuario_UName = @username";
                    using (SqlCommand deleteCartCommand = new SqlCommand(deleteCartQuery, connection, transaction))
                    {
                        deleteCartCommand.Parameters.AddWithValue("@username", username);
                        deleteCartCommand.ExecuteNonQuery();
                        deletedTables.Add("carrito");
                    }

                    // Borrar las líneas de pedido del usuario
                    string deleteLineaPedidoQuery = "DELETE FROM lineapedido WHERE pedido_id IN (SELECT pedido_id FROM pedido WHERE comprador_UName = @username OR vendedor_UName = @username)";
                    using (SqlCommand deleteLineaPedidoCommand = new SqlCommand(deleteLineaPedidoQuery, connection, transaction))
                    {
                        deleteLineaPedidoCommand.Parameters.AddWithValue("@username", username);
                        deleteLineaPedidoCommand.ExecuteNonQuery();
                        deletedTables.Add("lineapedido");
                    }

                    // Borrar los pedidos del usuario
                    string deletePedidosQuery = "DELETE FROM pedido WHERE comprador_UName = @username OR vendedor_UName = @username";
                    using (SqlCommand deletePedidosCommand = new SqlCommand(deletePedidosQuery, connection, transaction))
                    {
                        deletePedidosCommand.Parameters.AddWithValue("@username", username);
                        deletePedidosCommand.ExecuteNonQuery();
                        deletedTables.Add("pedido");
                    }

                    // Borrar comentarios del usuario
                    string deleteCommentsQuery = "DELETE FROM comentarios WHERE usuario_UName = @username";
                    using (SqlCommand deleteCommentsCommand = new SqlCommand(deleteCommentsQuery, connection, transaction))
                    {
                        deleteCommentsCommand.Parameters.AddWithValue("@username", username);
                        deleteCommentsCommand.ExecuteNonQuery();
                        deletedTables.Add("comentarios");
                    }

                    // Borrar los vehículos del usuario
                    string deleteVehiculosQuery = "DELETE FROM vehiculo WHERE vendedor_UName = @username";
                    using (SqlCommand deleteVehiculosCommand = new SqlCommand(deleteVehiculosQuery, connection, transaction))
                    {
                        deleteVehiculosCommand.Parameters.AddWithValue("@username", username);
                        deleteVehiculosCommand.ExecuteNonQuery();
                        deletedTables.Add("vehiculo");
                    }

                    // Finalmente, borra el usuario
                    string deleteUserQuery = "DELETE FROM usuarios WHERE username = @username";
                    using (SqlCommand deleteUserCommand = new SqlCommand(deleteUserQuery, connection, transaction))
                    {
                        deleteUserCommand.Parameters.AddWithValue("@username", username);
                        deleteUserCommand.ExecuteNonQuery();
                        deletedTables.Add("usuarios");
                    }

                    // Confirma la transacción
                    transaction.Commit();
                    return true;
                }
                catch (Exception ex)
                {
                    // Deshacer la transacción en caso de error
                    transaction.Rollback();
                    errorMessage = $"Error al eliminar la cuenta: {ex.Message}. Tablas eliminadas antes del error: {string.Join(", ", deletedTables)}.";
                    return false;
                }
            }
        }










        public bool FindUsuario(ENUsuario usuario)
        {
            try
            {
                using (SqlConnection con = new SqlConnection(constring))
                {
                    con.Open();
                    string query = "SELECT COUNT(*) FROM usuarios WHERE email = @Email";
                    SqlCommand cmd = new SqlCommand(query, con);
                    cmd.Parameters.AddWithValue("@Email", usuario.Email);

                    Console.WriteLine("Buscando usuario con email: " + usuario.Email);

                    int count = (int)cmd.ExecuteScalar();
                    Console.WriteLine("Número de registros encontrados: " + count); // Depuración
                    return count > 0;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error: " + ex.Message);
                return false;
            }
        }


        public bool FindUsuarioByEmail(ENUsuario usuario)
        {
            try
            {
                using (SqlConnection con = new SqlConnection(constring))
                {
                    con.Open();
                    string query = "SELECT * FROM usuarios WHERE email = @Email";
                    SqlCommand cmd = new SqlCommand(query, con);
                    cmd.Parameters.AddWithValue("@Email", usuario.Email);

                    using (SqlDataReader reader = cmd.ExecuteReader())
                    {
                        if (reader.Read())
                        {
                            usuario.Username = reader["username"].ToString();
                            usuario.Nombre = reader["nombre"].ToString();
                            usuario.Apellidos = reader["apellidos"].ToString();
                            usuario.Telefono = reader["telefono"].ToString();
                            usuario.Contrasenya = reader["contrasenya"].ToString();
                            usuario.Calle = reader["calle"].ToString();
                            usuario.Localidad = reader["localidad"].ToString();
                            usuario.Provincia = reader["provincia"].ToString();
                            usuario.Codigo_Postal = reader["codigo_postal"].ToString();
                            usuario.Email = reader["email"].ToString();
                            usuario.Admin = Convert.ToBoolean(reader["admin"]);
                            return true;
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error: " + ex.Message);
            }
            return false;
        }
        public bool ValidarContrasena(ENUsuario usuario)
        {
            try
            {
                using (SqlConnection con = new SqlConnection(constring))
                {
                    con.Open();
                    string query = "SELECT contrasenya FROM usuarios WHERE email = @Email";
                    SqlCommand cmd = new SqlCommand(query, con);
                    cmd.Parameters.AddWithValue("@Email", usuario.Email);

                    string contrasenaAlmacenada = cmd.ExecuteScalar()?.ToString();
                    return contrasenaAlmacenada == usuario.Contrasenya;
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine("Error: " + ex.Message);
            }
            return false;
        }

        public DataTable GetUsuarios()
        {
            try
            {
                using (SqlConnection con = new SqlConnection(constring))
                {
                    con.Open();
                    string query = "SELECT username, nombre, apellidos, email, telefono, calle, localidad, provincia, codigo_postal, admin FROM usuarios";
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