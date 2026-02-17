<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class NoticiasEditorModelo extends \Modelo\BaseModelo
{
    public function crearNoticia($data)
    {
        return $this->insertar('noticias', $data);
    }

    public function actualizarNoticia($id, $data)
    {
        return $this->actualizar('noticias', $data, $id);
    }

    public function eliminarNoticia($id)
    {
        return $this->eliminar('noticias', $id);
    }

    public function obtenerNoticiaPorId($id)
    {
        return $this->ejecutarConsultaPersonalizada(
            "SELECT * FROM noticias WHERE noticia_id = :id",
            ['id' => $id]
        );
    }

    public function crearBloqueNoticia($data)
    {
        return $this->insertar('noticias_contenido', $data);
    }

    public function obtenerBloquesPorNoticia($noticia_id)
    {
        return $this->ejecutarConsultaPersonalizada(
            "SELECT * FROM noticias_contenido WHERE noticia_id = :id ORDER BY posicion ASC",
            ['id' => $noticia_id]
        );
    }

    public function eliminarBloquesPorNoticia($noticia_id)
    {
        return $this->ejecutarConsultaPersonalizada(
            "DELETE FROM noticias_contenido WHERE noticia_id = :id",
            ['id' => $noticia_id]
        );
    }
}
