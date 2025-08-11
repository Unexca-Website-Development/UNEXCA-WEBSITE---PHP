<?php
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class ContactosModelo extends BaseModelo
{
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
                n.nombre AS nombre_nucleo,
                ca.titulo AS nombre_carrera
            FROM contactos_coordinadores_pnf AS ccp
            LEFT JOIN nucleos AS n ON ccp.nucleo_id = n.id
            LEFT JOIN carrera AS ca ON ccp.carrera_id = ca.id
            ORDER BY ccp.id ASC
        ";

        return $this->ejecutarConsultaPersonalizada($query);
    }

    public function obtenerContantosDirectivos()
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