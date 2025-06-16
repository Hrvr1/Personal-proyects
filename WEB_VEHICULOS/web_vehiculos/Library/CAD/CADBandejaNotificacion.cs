using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Data;
using System.Data.SqlClient;
using System.Configuration;
using Library.EN;

namespace Library
{
    public class CADBandejaNotificacion
    {
        private string connectionString;

        public CADBandejaNotificacion()
        {
            connectionString = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }

        public DataSet ListarNotificacionesPorUsuario(string usuario)
        {
            DataSet dataset = new DataSet();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"SELECT BN.notificacion_id ,LBN.tipo_notificacion, LBN.fecha_notificacion,
                        M.marca, V.modelo, V.url_imagen, V.kilometraje, V.precio, V.auto_manu, V.combustible, LBN.vehiculo_id
                        FROM bandejaNotificacion BN
                        INNER JOIN lineaBandejaNotificacion LBN ON BN.notificacion_id = LBN.notificacion_id
                        INNER JOIN vehiculo V ON LBN.vehiculo_id = V.vehiculo_id
                        INNER JOIN marcas M ON V.marca_id = M.marca_id
                        WHERE BN.usuario_UName = @usuario";
                SqlCommand command = new SqlCommand(query, connection);
                command.Parameters.AddWithValue("@usuario", usuario);

                SqlDataAdapter adapter = new SqlDataAdapter(command);
                adapter.Fill(dataset, "BandejaNotificacion");
            }

            return dataset;
        }

        public void AgregarBandejaNotificacion(ENBandejaNotificacion bandejaNotificacion, ENLineaBandejaNotificacion lineaNotificacion)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string queryBandeja = @"INSERT INTO bandejaNotificacion (usuario_UName) 
                                VALUES (@usuarioUName);
                                SELECT @@IDENTITY;"; // Recupera el último ID insertado

                string queryLinea = @"INSERT INTO lineaBandejaNotificacion (notificacion_id, vehiculo_id, tipo_notificacion, fecha_notificacion)
                              VALUES (@notificacionID, @vehiculoID, @tipoNotificacion, @fechaNotificacion)";

                SqlCommand commandBandeja = new SqlCommand(queryBandeja, connection);
                SqlCommand commandLinea = new SqlCommand(queryLinea, connection);

                commandBandeja.Parameters.AddWithValue("@usuarioUName", bandejaNotificacion.UsuarioUName);

                commandLinea.Parameters.AddWithValue("@vehiculoID", lineaNotificacion.VehiculoID);
                commandLinea.Parameters.AddWithValue("@tipoNotificacion", lineaNotificacion.TipoNotificacion);
                commandLinea.Parameters.AddWithValue("@fechaNotificacion", lineaNotificacion.FechaNotificacion);

                connection.Open();
                SqlTransaction transaction = connection.BeginTransaction();
                commandBandeja.Transaction = transaction;
                commandLinea.Transaction = transaction;

                try
                {
                    // Insertar en bandejaNotificacion y recuperar el último ID insertado
                    int notificacionID = Convert.ToInt32(commandBandeja.ExecuteScalar());
                    commandLinea.Parameters.AddWithValue("@notificacionID", notificacionID); // Usar el ID recuperado

                    // Insertar en lineaBandejaNotificacion
                    commandLinea.ExecuteNonQuery();

                    transaction.Commit();
                }
                catch (SqlException ex)
                {
                    transaction.Rollback();
                    Console.WriteLine("Error al agregar la bandeja de notificación: " + ex.Message);
                }
                finally
                {
                    connection.Close();
                }
            }
        }


        public int ObtenerUltimoNotificacionId()
        {
            int ultimoNotificacionId = 0;

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = "SELECT MAX(notificacion_id) AS ultimoId FROM bandejaNotificacion";

                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    try
                    {
                        connection.Open();
                        object result = command.ExecuteScalar();
                        if (result != null && result != DBNull.Value)
                        {
                            ultimoNotificacionId = Convert.ToInt32(result);
                        }
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Error al obtener el último ID de notificación: " + ex.Message);
                    }
                    finally
                    {
                        connection.Close();
                    }
                }
            }

            return ultimoNotificacionId;
        }


        public void EliminarBandejaNotificacionPorId(int notificacionId)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string queryLinea = @"DELETE FROM lineaBandejaNotificacion WHERE notificacion_id = @notificacionId";
                string queryBandeja = @"DELETE FROM bandejaNotificacion WHERE notificacion_id = @notificacionId";

                SqlCommand commandLinea = new SqlCommand(queryLinea, connection);
                SqlCommand commandBandeja = new SqlCommand(queryBandeja, connection);
                commandLinea.Parameters.AddWithValue("@notificacionId", notificacionId);
                commandBandeja.Parameters.AddWithValue("@notificacionId", notificacionId);

                connection.Open();
                SqlTransaction transaction = connection.BeginTransaction();
                commandLinea.Transaction = transaction;
                commandBandeja.Transaction = transaction;

                try
                {
                    commandLinea.ExecuteNonQuery();
                    commandBandeja.ExecuteNonQuery();
                    transaction.Commit();
                }
                catch (SqlException ex)
                {
                    transaction.Rollback();
                    Console.WriteLine("Error al eliminar la bandeja de notificación: " + ex.Message);
                }
                finally
                {
                    connection.Close();
                }
            }
        }
    }
}
