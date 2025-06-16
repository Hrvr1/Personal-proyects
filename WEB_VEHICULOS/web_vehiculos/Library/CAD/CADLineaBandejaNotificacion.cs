using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;

namespace Library
{
    public class CADLineaBandejaNotificacion
    {
        private string connectionString;

        public CADLineaBandejaNotificacion()
        {
            connectionString = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }

        public DataSet ListarNotificacionesPorUsuario(string usuario)
        {
            DataSet dataset = new DataSet();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"SELECT LBN.notificacion_id, LBN.tipo_notificacion, LBN.fecha_notificacion,
                                    M.marca, V.modelo, LBN.vehiculo_id, V.url_imagen, V.kilometraje, V.precio, V.auto_manu, V.combustible
                                 FROM lineaBandejaNotificacion LBN
                                 INNER JOIN vehiculo V ON LBN.vehiculo_id = V.vehiculo_id
                                 INNER JOIN marcas M ON V.marca_id = M.marca_id
                                 INNER JOIN bandejaNotificacion BN ON LBN.notificacion_id = BN.notificacion_id
                                 WHERE BN.usuario_UName = @usuario";
                SqlCommand command = new SqlCommand(query, connection);
                command.Parameters.AddWithValue("@usuario", usuario);

                SqlDataAdapter adapter = new SqlDataAdapter(command);
                adapter.Fill(dataset, "LineaBandejaNotificacion");
            }

            return dataset;
        }

        public DataSet ListarNotificacionesPorUsuarioYTipo(string usuario, string tipoNotificacion)
        {
            DataSet dataset = new DataSet();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"SELECT LBN.notificacion_id, LBN.tipo_notificacion, LBN.fecha_notificacion,
                                    M.marca, V.modelo, LBN.vehiculo_id, V.url_imagen, V.kilometraje, V.precio, V.auto_manu, V.combustible
                                 FROM lineaBandejaNotificacion LBN
                                 INNER JOIN vehiculo V ON LBN.vehiculo_id = V.vehiculo_id
                                 INNER JOIN marcas M ON V.marca_id = M.marca_id
                                 INNER JOIN bandejaNotificacion BN ON LBN.notificacion_id = BN.notificacion_id
                                 WHERE BN.usuario_UName = @usuario
                                 AND LBN.tipo_notificacion = @tipoNotificacion";
                SqlCommand command = new SqlCommand(query, connection);
                command.Parameters.AddWithValue("@usuario", usuario);
                command.Parameters.AddWithValue("@tipoNotificacion", tipoNotificacion);

                SqlDataAdapter adapter = new SqlDataAdapter(command);
                adapter.Fill(dataset, "LineaBandejaNotificacion");
            }

            return dataset;
        }

        public List<string> ObtenerTiposNotificacion()
        {
            List<string> tiposNotificacion = new List<string>();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"SELECT DISTINCT tipo_notificacion FROM lineaBandejaNotificacion";
                SqlCommand command = new SqlCommand(query, connection);

                connection.Open();

                using (SqlDataReader reader = command.ExecuteReader())
                {
                    while (reader.Read())
                    {
                        tiposNotificacion.Add(reader["tipo_notificacion"].ToString());
                    }
                }
            }

            return tiposNotificacion;
        }

        public void EliminarNotificacionPorId(int notificacionId)
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
                    Console.WriteLine("Error al eliminar la notificación: " + ex.Message);
                }
                finally
                {
                    connection.Close();
                }
            }
        }
    }
}
