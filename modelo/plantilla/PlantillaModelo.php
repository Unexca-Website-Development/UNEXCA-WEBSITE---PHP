<?php
namespace Modelo\Plantilla;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

/**
 * Clase PlantillaModelo
 *
 * Gestiona la obtención de menús y enlaces (estáticos y dinámicos) 
 * para la plantilla del sistema.
 *
 * Extiende BaseModelo para usar operaciones genéricas de base de datos.
 *
 * @package Modelo\Plantilla
 */
class PlantillaModelo extends \Modelo\BaseModelo
{
    /**
     * Obtiene un menú por su nombre
     *
     * @param string $nombre Nombre del menú a buscar
     * @return array|null Arreglo con 'id' y 'nombre' del menú si existe, null si no
     */
    public function obtenerMenuPorNombre($nombre)
    {
        $sql = "SELECT id, nombre FROM menus WHERE nombre = :nombre LIMIT 1";
        $resultado = $this->ejecutarConsultaPersonalizada($sql, ['nombre' => $nombre]);
        return $resultado ? $resultado[0] : null;
    }

    /**
     * Obtiene los enlaces jerárquicos de un menú
     *
     * Combina enlaces estáticos y dinámicos del menú especificado, 
     * retornando un arreglo con:
     * - 'estaticos': lista de enlaces estáticos padre-hijo
     * - 'dinamicos': lista de enlaces dinámicos
     *
     * @param int $menu_id ID del menú
     * @return array Arreglo con enlaces organizados por tipo
     */
    public function obtenerEnlacesJerarquicos($menu_id)
    {
        // Enlaces estáticos (padre-hijo)
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

        // Enlaces dinámicos
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
