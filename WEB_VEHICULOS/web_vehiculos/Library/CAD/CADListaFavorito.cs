using System;
using System.Configuration;
using System.Data;
using System.Data.SqlClient;

namespace Library
{
    public class CADListaFavorito
    {
        private string connectionString;

        public CADListaFavorito()
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
                        SELECT lf.lista_favorito_id, lf.usuario_UName, v.vehiculo_id, v.precio,
                        v.modelo, m.marca, v.url_imagen, v.auto_manu, v.combustible, v.kilometraje
                        FROM lista_favoritos lf
                        INNER JOIN vehiculo v ON lf.vehiculo_id = v.vehiculo_id
                        INNER JOIN marcas m ON m.marca_id = v.marca_id
                        WHERE lf.usuario_UName = @usuario";

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
                    Console.WriteLine("SQL Error al mostrar favoritos: " + ex.Message);
                }
                catch (Exception ex)
                {
                    Console.WriteLine("Error al mostrar favoritos: " + ex.Message);
                }
            }
            return dataset;
        }

        public bool AddFavoriteCar(string usuario, int vehiculoId)
            {
                using (SqlConnection connection = new SqlConnection(connectionString))
                {
                    string query = @"INSERT INTO lista_favoritos (usuario_UName, vehiculo_id) 
                                     VALUES (@usuario, @vehiculoId)";

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
                            Console.WriteLine("Error adding favorite car: " + ex.Message);
                            return false;
                        }
                    }
                }
            }

        public bool RemoveFavoriteCar(string usuario, int favoritoId)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"DELETE FROM lista_favoritos
                                 WHERE usuario_UName = @usuario AND lista_favorito_id = @favoritoId";

                using (SqlCommand command = new SqlCommand(query, connection))
                {
                    command.Parameters.AddWithValue("@usuario", usuario);
                    command.Parameters.AddWithValue("@favoritoId", favoritoId);

                    try
                    {
                        connection.Open();
                        int result = command.ExecuteNonQuery();
                        return true;
                    }
                    catch (Exception ex)
                    {
                        Console.WriteLine("Error removing favorite car: " + ex.Message);
                        return false;
                    }
                }
            }
        }

        public bool DeleteAll(string usuario)
        {
            using (SqlConnection connection = new SqlConnection(connectionString))
            {
                string query = @"DELETE FROM lista_favoritos WHERE usuario_UName = @usuario";

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
    }
}
