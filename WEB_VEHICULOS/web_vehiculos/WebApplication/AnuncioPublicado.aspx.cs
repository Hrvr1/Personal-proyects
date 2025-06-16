using System;
using System.Web.UI;
using Library;
using Library.CAD;
using Library.EN;

namespace WebApplication
{
    public partial class AnuncioPublicado : Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                UpdateProgress();
            }
        }

        protected void ButtonNext1_Click(object sender, EventArgs e)
        {
            Page.Validate("Group1");
            if (Page.IsValid && ValidateView1())
            {
                MultiView1.ActiveViewIndex = 1;
                UpdateProgress();
            }
        }

        protected void ButtonPrevious1_Click(object sender, EventArgs e)
        {
            MultiView1.ActiveViewIndex = 0;
            UpdateProgress();
        }

        protected void ButtonNext2_Click(object sender, EventArgs e)
        {
            Page.Validate("Group2");
            if (Page.IsValid && ValidateView2())
            {
                MultiView1.ActiveViewIndex = 2;
                UpdateProgress();
            }
        }

        protected void ButtonPrevious2_Click(object sender, EventArgs e)
        {
            MultiView1.ActiveViewIndex = 1;
            UpdateProgress();
        }

        protected void ButtonNext3_Click(object sender, EventArgs e)
        {
            Page.Validate("Group3");
            if (Page.IsValid && ValidateView3())
            {
                MultiView1.ActiveViewIndex = 3;
                UpdateProgress();
            }
        }

        protected void ButtonPrevious3_Click(object sender, EventArgs e)
        {
            MultiView1.ActiveViewIndex = 2;
            UpdateProgress();
        }
        protected void ButtonSubmit_Click(object sender, EventArgs e)
        {
            Page.Validate();
            if (Page.IsValid && ValidateView4())
            {
                string fileName = "";
                if (FotoVehiculo.HasFile)
                {
                    fileName = System.IO.Path.GetFileName(FotoVehiculo.PostedFile.FileName);
                    string filePath = Server.MapPath("~/App_Images/vehiculos/") + fileName;
                    FotoVehiculo.PostedFile.SaveAs(filePath);
                    fileName = "/App_Images/vehiculos/" + fileName;
                }

                if (Session["usuarios"] == null)
                {
                    lblErrorMessage.Text = "Por favor, inicie sesión o regístrese para publicar un anuncio.";
                    lblErrorMessage.Visible = true;
                    return;
                }

                ENUsuario user = (ENUsuario)Session["usuarios"];
                string vendedor_UName = user.Username;

                // Crear la instancia de ENMarcas
                ENMarcas marca = new ENMarcas
                {
                    Marca_id = 1, 
                    Marca = Marca.Text
                };

                // Reemplazar coma por punto para asegurar la correcta conversión a decimal
                string precioTexto = Precio.Text.Replace(',', '.');

                // Validar la longitud de la parte entera antes de convertir a decimal
                string[] parts = precioTexto.Split('.');
                int integerPartLength = parts[0].Length;
                int decimalPartLength = parts.Length > 1 ? parts[1].Length : 0;

                if (integerPartLength > 8 || decimalPartLength > 2)
                {
                    lblErrorMessage.Text = "El precio debe tener hasta 8 dígitos en la parte entera y hasta 2 dígitos en la parte decimal.";
                    lblErrorMessage.Visible = true;
                    return;
                }

                if (!decimal.TryParse(precioTexto, out decimal precio))
                {
                    lblErrorMessage.Text = "El precio debe ser un número decimal.";
                    lblErrorMessage.Visible = true;
                    return;
                }

               
                ENVehiculo venta = new ENVehiculo(
                    vehiculo_id: 1, // 1el valor 
                    marca_id: marca.Marca_id,
                    modelo: Modelo.Text,
                    kilometraje: int.Parse(Kilometros.Text),
                    color: Color.Text,
                    precio: precio, 
                    anyo: int.Parse(Anio.Text),
                    auto_manu: Transmision.Text,
                    combustible: Combustible.Text,
                    descripcion: InformacionAdicional.Text,
                    valoracion: 0,
                    url_imagen: fileName,
                    vendido: 0,
                    vendedor_UName: vendedor_UName
                );

                // Guardar los datos para que se muestren en el resumen
                Session["AñoCoche"] = venta.Anyo.ToString();
                Session["MarcaCoche"] = marca.Marca; // Usa el objeto ENMarcas
                Session["ModeloCoche"] = venta.Modelo;
                Session["CombustibleCoche"] = venta.Combustible;
                Session["TransmisionCoche"] = venta.Auto_Manu;
                Session["ColorCoche"] = venta.Color;
                Session["KilometrosCoche"] = venta.Kilometraje.ToString();
                Session["DescripcionAdicionalCoche"] = venta.Descripcion;
                Session["PrecioCoche"] = venta.Precio.ToString();
                Session["UrlImagen"] = venta.Url_imagen;

                CADVehiculo cadVenta = new CADVehiculo();
                bool success = cadVenta.Create(venta, marca.Marca); // Pasar la marca como string

                if (success)
                {
                    Response.Redirect("ResumenAnuncio.aspx");
                }
                else
                {
                    lblErrorMessage.Text = "Error al publicar el anuncio. Por favor, inténtelo de nuevo.";
                    lblErrorMessage.Visible = true;
                }
            }
        }






        private void UpdateProgress()
        {
            int step = MultiView1.ActiveViewIndex;
            progressBarContainer.Style["width"] = ((step + 1) * 25) + "%";

            step1.CssClass = "step " + (step >= 0 ? "active" : "");
            step2.CssClass = "step " + (step >= 1 ? "active" : "");
            step3.CssClass = "step " + (step >= 2 ? "active" : "");
            step4.CssClass = "step " + (step >= 3 ? "active" : "");
        }

        private bool ValidateView1()
        {
            if (string.IsNullOrWhiteSpace(Anio.Text) || !int.TryParse(Anio.Text, out int anio) || anio > 2024)
            {
                lblErrorMessage.Text = "El año es obligatorio y debe ser un número no mayor a 2024.";
                lblErrorMessage.Visible = true;
                return false;
            }
            if (string.IsNullOrWhiteSpace(Marca.Text) || Marca.Text.Length > 45)
            {
                lblErrorMessage.Text = "La marca es obligatoria y debe tener un máximo de 45 caracteres.";
                lblErrorMessage.Visible = true;
                return false;
            }
            if (string.IsNullOrWhiteSpace(Modelo.Text) || Modelo.Text.Length > 45)
            {
                lblErrorMessage.Text = "El modelo es obligatorio y debe tener un máximo de 45 caracteres.";
                lblErrorMessage.Visible = true;
                return false;
            }
            lblErrorMessage.Visible = false;
            return true;
        }

        private bool ValidateView2()
        {
            if (string.IsNullOrWhiteSpace(Combustible.Text) || Combustible.Text.Length > 45)
            {
                lblErrorMessage.Text = "El combustible es obligatorio y debe tener un máximo de 45 caracteres.";
                lblErrorMessage.Visible = true;
                return false;
            }
            if (string.IsNullOrWhiteSpace(Transmision.Text) || Transmision.Text.Length > 45)
            {
                lblErrorMessage.Text = "La transmisión es obligatoria y debe tener un máximo de 45 caracteres.";
                lblErrorMessage.Visible = true;
                return false;
            }
            if (string.IsNullOrWhiteSpace(Color.Text) || Color.Text.Length > 45)
            {
                lblErrorMessage.Text = "El color debe tener un máximo de 45 caracteres.";
                lblErrorMessage.Visible = true;
                return false;
            }
            if (string.IsNullOrWhiteSpace(Kilometros.Text) || !int.TryParse(Kilometros.Text, out int kilometros) || kilometros > 999999)
            {
                lblErrorMessage.Text = "Los kilómetros son obligatorios y deben ser un número no mayor a 999999.";
                lblErrorMessage.Visible = true;
                return false;
            }
            lblErrorMessage.Visible = false;
            return true;
        }

        private bool ValidateView3()
        {
            if (string.IsNullOrWhiteSpace(Precio.Text))
            {
                lblErrorMessage.Text = "El precio es obligatorio.";
                lblErrorMessage.Visible = true;
                return false;
            }

            // Reemplazar coma por punto para asegurar la correcta conversión a decimal
            string precioTexto = Precio.Text.Replace(',', '.');

            // Validar la longitud de la parte entera antes de convertir a decimal
            string[] parts = precioTexto.Split('.');
            int integerPartLength = parts[0].Length;
            int decimalPartLength = parts.Length > 1 ? parts[1].Length : 0;  

            if (integerPartLength > 8 || decimalPartLength > 2)
            {
                lblErrorMessage.Text = "El precio debe tener hasta 8 dígitos en la parte entera y hasta 2 dígitos en la parte decimal.";
                lblErrorMessage.Visible = true;
                return false;
            }

            if (!decimal.TryParse(precioTexto, out decimal precio))
            {
                lblErrorMessage.Text = "El precio debe ser un número decimal.";
                lblErrorMessage.Visible = true;
                return false;
            }

            if (string.IsNullOrWhiteSpace(InformacionAdicional.Text) || InformacionAdicional.Text.Length > 200)
            {
                lblErrorMessage.Text = "La descripción debe tener un máximo de 200 caracteres.";
                lblErrorMessage.Visible = true;
                return false;
            }

            lblErrorMessage.Visible = false;
            return true;
        }


        private bool ValidateView4()
        {
            if (!FotoVehiculo.HasFile)
            {
                lblErrorMessage.Text = "La foto del vehículo es obligatoria.";
                lblErrorMessage.Visible = true;
                return false;
            }
            lblErrorMessage.Visible = false;
            return true;
        }
    }
}
