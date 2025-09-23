<?php
require_once colocar_ruta_sistema('@modelo/baseModelo.php');

class PlantillaModelo extends BaseModelo
{
    public function obtenerMenuPorNombre($nombre)
    {
        $sql = "SELECT id, nombre FROM menus WHERE nombre = :nombre LIMIT 1";
        $resultado = $this->ejecutarConsultaPersonalizada($sql, ['nombre' => $nombre]);
        return $resultado ? $resultado[0] : null;
    }

    public function obtenerEnlacesJerarquicos($menu_id)
    {
        $sql = "SELECT 
                    p.id          AS padre_id,
                    p.titulo      AS padre_titulo,
                    p.url         AS padre_url,
                    h.id          AS hijo_id,
                    h.titulo      AS hijo_titulo,
                    h.url         AS hijo_url
                FROM menu_enlaces_estaticos p
                LEFT JOIN menu_enlaces_estaticos h 
                       ON h.padre_id = p.id
                WHERE p.menu_id = :menu_id
                  AND p.padre_id IS NULL
                ORDER BY p.orden ASC, h.orden ASC";
        $enlaces_estaticos = $this->ejecutarConsultaPersonalizada($sql, ['menu_id' => $menu_id]);

        $sql = "SELECT id, titulo, url, tabla_origen, registro_id, padre_id, orden 
                FROM menu_enlaces_dinamicos 
                WHERE menu_id = :menu_id
                ORDER BY orden ASC";
        $enlaces_dinamicos = $this->ejecutarConsultaPersonalizada($sql, ['menu_id' => $menu_id]);

        return [
            'estaticos' => $enlaces_estaticos,
            'dinamicos' => $enlaces_dinamicos
        ];
    }
}
