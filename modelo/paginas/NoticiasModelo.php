<?php
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class NoticiasModelo extends \Modelo\BaseModelo
{
    /**
     * Obtiene las noticias con estado 'publicado' ordenadas por fecha de publicación.
     * 
     * @param int $limite Máximo de noticias a retornar.
     * @return array
     */
    public function obtenerNoticiasPublicadas(int $limite = 4): array
    {
        $sql = "SELECT * FROM noticias 
                WHERE estado = 'publicado' 
                ORDER BY fecha_publicacion DESC 
                LIMIT :limite";
        
        return $this->consultar($sql, ['limite' => $limite]);
    }

    /**
     * Obtiene una noticia y sus bloques de contenido por su URL.
     * 
     * @param string $url
     * @return array|null
     */
    public function obtenerPorUrl(string $url): ?array
    {
        $sql = "SELECT * FROM noticias WHERE url = :url AND estado = 'publicado' LIMIT 1";
        $resultado = $this->consultar($sql, ['url' => $url]);

        if (empty($resultado)) {
            return null;
        }

        $noticia = $resultado[0];

        $sqlContenido = "SELECT * FROM noticias_contenido 
                         WHERE noticia_id = :noticia_id 
                         ORDER BY posicion ASC";
        $contenido = $this->consultar($sqlContenido, ['noticia_id' => $noticia['noticia_id']]);

        return [
            'noticia' => $noticia,
            'contenido' => $contenido
        ];
    }
}