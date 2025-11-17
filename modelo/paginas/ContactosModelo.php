<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

/**
 * Clase ContactosModelo
 *
 * Representa las tablas de contactos:
 * - contactos_coordinadores_pnf
 * - contactos_directivos
 *
 * Proporciona métodos para obtener información detallada de coordinadores y directivos.
 *
 * @package Modelo\Paginas
 */
class ContactosModelo extends \Modelo\BaseModelo
{
    /**
     * Obtiene todos los contactos de coordinadores PNF
     *
     * Incluye información de la carrera asociada.
     *
     * @return array Lista de coordinadores
     * @throws \Exception Si falla la consulta
     */
    public function obtenerContactosCoordinadores()
    {
        $query = "
            SELECT 
                ccp.id,
                ccp.nombre_completo,
                ccp.titulo_academico,
                ccp.telefono,
                ccp.email,
                ccp.oficina,
                ccp.horario_atencion,
                ca.titulo AS nombre_carrera
            FROM contactos_coordinadores_pnf AS ccp
            LEFT JOIN carrera AS ca ON ccp.carrera_id = ca.id
            ORDER BY ccp.id ASC
        ";

        return $this->ejecutarConsultaPersonalizada($query);
    }

    /**
     * Obtiene todos los contactos de directivos
     *
     * Incluye información del núcleo asociado.
     *
     * @return array Lista de directivos
     * @throws \Exception Si falla la consulta
     */
    public function obtenerContactosDirectivos()
    {
        $query = "
            SELECT 
                cd.id,
                cd.nombre_completo,
                cd.cargo,
                cd.telefono,
                cd.email,
                cd.oficina,
                n.nombre AS nombre_nucleo
            FROM contactos_directivos AS cd
            LEFT JOIN nucleos AS n ON cd.nucleo_id = n.id
            ORDER BY cd.id ASC
        ";
        return $this->ejecutarConsultaPersonalizada($query);
    }
}
