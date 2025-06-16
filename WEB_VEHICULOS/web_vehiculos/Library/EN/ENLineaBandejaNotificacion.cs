using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Library
{
    public class ENLineaBandejaNotificacion
    {
        private int notificacion_id;
        private int vehiculo_id;
        private string tipo_notificacion;
        private DateTime fecha_notificacion;

        public int NotificacionID {
            get { return notificacion_id; }
            set { notificacion_id = value; }
        }
        public int VehiculoID {
            get { return vehiculo_id; }
            set { vehiculo_id = value; }
        }
        public string TipoNotificacion {
            get { return tipo_notificacion; }
            set { tipo_notificacion = value; }
        }
        public DateTime FechaNotificacion {
            get { return fecha_notificacion; }
            set { fecha_notificacion = value; }
        }
    }
}
