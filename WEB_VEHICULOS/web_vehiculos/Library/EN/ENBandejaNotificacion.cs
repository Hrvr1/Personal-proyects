using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    public class ENBandejaNotificacion
    {
        private int notificacion_id;
        private string usuario_UName;

        public int NotificacionID
        {
            get { return notificacion_id; }
            set { notificacion_id = value; }
        }
        public string UsuarioUName
        {
            get { return usuario_UName; }
            set { usuario_UName = value; }
        }
    }
}
