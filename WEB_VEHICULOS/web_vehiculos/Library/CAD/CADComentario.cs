using System;
using System.Data;
using System.Data.SqlClient;
using System.Collections.Generic;
using System.Configuration;
using Library.EN;

namespace Library
{
    public class CADComentario
    {
        private string connectionString;

        public CADComentario()
        {
            connectionString = ConfigurationManager.ConnectionStrings["Database"].ConnectionString;
        }

        public List<ENComentario> GetComentarios(int? vehiculoId = null, int? comentarioId = null)
        {
            List<ENComentario> comentarios = new List<ENComentario>();

            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                connection.Open();
                string sql;

                if (comentarioId.HasValue)
                {
                    sql = "SELECT comentario_id, vehiculo_id, usuario_UName, comentario, fecha_comentario FROM comentarios WHERE comentario_id = @ComentarioId";
                }
                else if (vehiculoId.HasValue)
                {
                    sql = "SELECT comentario_id, vehiculo_id, usuario_UName, comentario, fecha_comentario FROM comentarios WHERE vehiculo_id = @VehiculoId";
                }
                else
                {
                    throw new ArgumentException("Either vehiculoId or comentarioId must be provided.");
                }

                using (SqlCommand command = new SqlCommand(sql, connection))
                {
                    if (comentarioId.HasValue)
                    {
                        command.Parameters.AddWithValue("@ComentarioId", comentarioId.Value);
                    }
                    else
                    {
                        command.Parameters.AddWithValue("@VehiculoId", vehiculoId.Value);
                    }

                    using (SqlDataReader reader = command.ExecuteReader())
                    {
                        while (reader.Read())
                        {
                            ENComentario comentario = new ENComentario(
                                Convert.ToInt32(reader["comentario_id"]),
                                Convert.ToInt32(reader["vehiculo_id"]),
                                reader["usuario_UName"].ToString(),
                                reader["comentario"].ToString(),
                                Convert.ToDateTime(reader["fecha_comentario"])
                            );
                            comentarios.Add(comentario);
                        }
                    }
                }
            }

            return comentarios;
        }

        public void AddComentario(ENComentario comentario)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                connection.Open();

                // Obtener el valor maxde comentario_id
                string getMaxIdSql = "SELECT ISNULL(MAX(comentario_id), 0) + 1 FROM comentarios";
                SqlCommand getMaxIdCommand = new SqlCommand(getMaxIdSql, connection);
                int newComentarioId = (int)getMaxIdCommand.ExecuteScalar();

                comentario.ComentarioId = newComentarioId;

                string sql = "INSERT INTO comentarios (comentario_id, vehiculo_id, usuario_UName, comentario, fecha_comentario) VALUES (@ComentarioId, @VehiculoId, @UsuarioUName, @Comentario, @FechaComentario)";
                using (SqlCommand command = new SqlCommand(sql, connection))
                {
                    command.Parameters.AddWithValue("@ComentarioId", comentario.ComentarioId);
                    command.Parameters.AddWithValue("@VehiculoId", comentario.VehiculoId);
                    command.Parameters.AddWithValue("@UsuarioUName", comentario.UsuarioUName);
                    command.Parameters.AddWithValue("@Comentario", comentario.Comentario);
                    command.Parameters.AddWithValue("@FechaComentario", comentario.FechaComentario);

                    command.ExecuteNonQuery();
                }
            }
        }

        public void UpdateComentario(ENComentario comentario)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                connection.Open();
                string sql = "UPDATE comentarios SET comentario = @Comentario WHERE comentario_id = @ComentarioId";

                using (SqlCommand command = new SqlCommand(sql, connection))
                {
                    command.Parameters.AddWithValue("@Comentario", comentario.Comentario);
                    command.Parameters.AddWithValue("@ComentarioId", comentario.ComentarioId);

                    command.ExecuteNonQuery();
                }
            }
        }
        public void DeleteComentario(int comentarioId)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                connection.Open();
                string sql = "DELETE FROM comentarios WHERE comentario_id = @ComentarioId";

                using (SqlCommand command = new SqlCommand(sql, connection))
                {
                    command.Parameters.AddWithValue("@ComentarioId", comentarioId);
                    command.ExecuteNonQuery();
                }
            }
        }

    }
}
