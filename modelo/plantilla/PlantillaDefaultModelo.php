<?php
namespace Modelo\Plantilla;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

/**
 * Clase PlantillaDefaultModelo
 *
 * Gestiona la obtención de menús y enlaces (estáticos y dinámicos)
 * para la plantilla del sistema.
 *
 * @package Modelo\Plantilla
 */
class PlantillaDefaultModelo extends \Modelo\BaseModelo
{
    /**
     * Obtiene un menú por su nombre
     *
     * @param string $nombre
     * @return array|null
     */
    public function obtenerMenuPorNombre($nombre)
    {
        $sql = "SELECT id, nombre FROM menus WHERE nombre = :nombre LIMIT 1";
        $resultado = $this->consultar($sql, ['nombre' => $nombre]);
        return $resultado ? $resultado[0] : null;
    }

    /**
     * Obtiene los enlaces jerárquicos de un menú
     *
     * @param int $menu_id
     * @return array
     */
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
        $enlaces_estaticos = $this->consultar($sql, ['menu_id' => $menu_id]);

        $sql = "SELECT id, titulo, url, tabla_origen, registro_id, padre_id, orden 
                FROM menu_enlaces_dinamicos 
                WHERE menu_id = :menu_id
                ORDER BY orden ASC";
        $enlaces_dinamicos = $this->consultar($sql, ['menu_id' => $menu_id]);

        return [
            'estaticos' => $enlaces_estaticos,
            'dinamicos' => $enlaces_dinamicos
        ];
    }
}