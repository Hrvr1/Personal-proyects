using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data.SqlClient;
using System.Web.Script.Serialization;
using System.Web.UI;

namespace WebApplication
{
    public partial class mejoras : Page
    {
        protected string Labels { get; set; }
        protected string SalesData { get; set; }
        protected string TopClients { get; set; }
        protected string TopProducts { get; set; }
        protected string Transacciones { get; set; }
        protected decimal TotalGanancias { get; set; }
        protected decimal TotalGastos { get; set; }
        protected decimal MetaMensual { get; set; } = 80000; // Por ejemplo, 80000 €

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                LoadChartData();
                LoadTopClients();
                LoadTransactions();
                LoadTopProducts();
                CalculateTotals();
            }
        }

        private void LoadChartData()
        {
            // Ejemplo de datos
            Labels = "['ENE', 'FEB', 'MAR', 'ABR', 'JUN', 'JUL']";
            SalesData = "[1, 19, 3, 5, 2, 3]";
        }

        private void LoadTopClients()
        {
            List<string> topClients = new List<string>();
            string query = @"
                SELECT TOP 10 u.username
                FROM usuarios u
                JOIN pedido p ON u.username = p.vendedor_UName
                GROUP BY u.username
                ORDER BY SUM(p.total) DESC";

            using (SqlConnection conn = new SqlConnection(ConfigurationManager.ConnectionStrings["Database"].ConnectionString))
            {
                conn.Open();
                SqlCommand cmd = new SqlCommand(query, conn);
                SqlDataReader reader = cmd.ExecuteReader();

                while (reader.Read())
                {
                    topClients.Add("'" + reader["username"].ToString() + "'");
                }
            }

            TopClients = "[" + string.Join(",", topClients) + "]";
        }

        private void LoadTransactions()
        {
            List<dynamic> transactions = new List<dynamic>();

            using (SqlConnection conn = new SqlConnection(ConfigurationManager.ConnectionStrings["Database"].ConnectionString))
            {
                conn.Open();
                string query = @"
                    SELECT u.username AS Cliente, p.fecha_pedido AS Fecha, v.modelo AS Modelo, m.marca AS Marca, p.total AS Precio
                    FROM pedido p
                    JOIN usuarios u ON p.comprador_UName = u.username
                    JOIN lineapedido lp ON p.pedido_id = lp.pedido_id
                    JOIN vehiculo v ON lp.vehiculo_id = v.vehiculo_id
                    JOIN marcas m ON v.marca_id = m.marca_id
                    ORDER BY p.fecha_pedido DESC";

                SqlCommand cmd = new SqlCommand(query, conn);
                SqlDataReader reader = cmd.ExecuteReader();

                Random random = new Random();
                string[] estados = { "Pendiente", "Completado", "Cancelado" };

                while (reader.Read())
                {
                    transactions.Add(new
                    {
                        Cliente = reader["Cliente"].ToString(),
                        Fecha = Convert.ToDateTime(reader["Fecha"]).ToString("dd MMMM yyyy"),
                        Modelo = reader["Modelo"].ToString(),
                        Marca = reader["Marca"].ToString(),
                        Estado = estados[random.Next(estados.Length)], // Estado aleatorio
                        Precio = Convert.ToDecimal(reader["Precio"])
                    });
                }
                reader.Close();
            }

            Transacciones = new JavaScriptSerializer().Serialize(transactions);
        }
        private void LoadTopProducts()
        {
            List<object> topProducts = new List<object>();
            string query = @"
                SELECT TOP 10 v.modelo AS Producto, m.marca AS Marca, v.modelo AS Modelo, v.precio AS Precio, u.username AS Vendedor
                FROM vehiculo v
                JOIN usuarios u ON v.vendedor_UName = u.username
                JOIN marcas m ON v.marca_id = m.marca_id
                ORDER BY v.vendido DESC";

            using (SqlConnection conn = new SqlConnection(ConfigurationManager.ConnectionStrings["Database"].ConnectionString))
            {
                conn.Open();
                SqlCommand cmd = new SqlCommand(query, conn);
                SqlDataReader reader = cmd.ExecuteReader();

                while (reader.Read())
                {
                    topProducts.Add(new
                    {
                        Producto = reader["Producto"].ToString(),
                        Marca = reader["Marca"].ToString(),
                        Modelo = reader["Modelo"].ToString(),
                        Precio = Convert.ToDecimal(reader["Precio"]),
                        Vendedor = reader["Vendedor"].ToString()
                    });
                }
            }

            TopProducts = Newtonsoft.Json.JsonConvert.SerializeObject(topProducts);
        }

        private void CalculateTotals()
        {
            using (SqlConnection conn = new SqlConnection(ConfigurationManager.ConnectionStrings["Database"].ConnectionString))
            {
                conn.Open();

                // Calcular ganancias totales
                string gananciasQuery = "SELECT SUM(total) FROM pedido";
                SqlCommand gananciasCmd = new SqlCommand(gananciasQuery, conn);
                TotalGanancias = Convert.ToDecimal(gananciasCmd.ExecuteScalar());

                // Calcular gastos totales
                string gastosQuery = "SELECT SUM(importe) FROM lineapedido";
                SqlCommand gastosCmd = new SqlCommand(gastosQuery, conn);
                TotalGastos = Convert.ToDecimal(gastosCmd.ExecuteScalar());
            }
        }
    }
}
