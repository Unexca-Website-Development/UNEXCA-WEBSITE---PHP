<?php
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class InicioModelo extends BaseModelo
{
    public function obtenerCarrerasSimples()
    {
        return $this->obtenerTodos('carrera');
    }

    public function obtenerNoticiasSimples(int $limite = 5): array
    {
        if ($limite < 1) {
            $limite = 5;
        }

        $sql = "
            SELECT noticia_id, titulo_principal, descripcion_corta, imagen_principal, url, fecha_publicacion
            FROM noticias
            ORDER BY fecha_publicacion DESC
            LIMIT :limite
        ";

        return $this->ejecutarConsultaPersonalizada($sql, [':limite' => $limite]);
    }
};