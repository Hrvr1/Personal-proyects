using System;


namespace Library.EN
{
    public class ENComentario
    {
        private int comentario_id;
        private int vehiculo_id;
        private string usuario_UName;
        private string comentario;
        private DateTime fecha_comentario;

        public int ComentarioId
        {
            get { return comentario_id; }
            set { comentario_id = value; }
        }

        public int VehiculoId
        {
            get { return vehiculo_id; }
            set { vehiculo_id = value; }
        }

        public string UsuarioUName
        {
            get { return usuario_UName; }
            set { usuario_UName = value; }
        }

        public string Comentario
        {
            get { return comentario; }
            set { comentario = value; }
        }

        public DateTime FechaComentario
        {
            get { return fecha_comentario; }
            set { fecha_comentario = value; }
        }

        public ENComentario(int comentarioId, int vehiculoId, string usuarioUName, string comentario, DateTime fechaComentario)
        {
            ComentarioId = comentarioId;
            VehiculoId = vehiculoId;
            UsuarioUName = usuarioUName;
            Comentario = comentario;
            FechaComentario = fechaComentario;
        }
    }
}
