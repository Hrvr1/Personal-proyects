using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace WebApplication
{
	public partial class venta : System.Web.UI.Page
	{
		protected void Page_Load(object sender, EventArgs e)
		{

		}
       
        protected void btnPublish_Click(object sender, EventArgs e)
        {
            Response.Redirect("~/AnuncioPublicado.aspx"); 
        }
        protected void btnSellInOneHour_Click(object sender, EventArgs e)
        {
            
        }
    }
}