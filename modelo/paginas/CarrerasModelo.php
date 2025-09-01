<?php

require_once colocar_ruta_sistema('@modelo/BaseModelo');

class CarrerasModelo extends BaseModelo
{
    public function obtenerCarrerasPorSlug($slug)
    {
        $sql = "
            SELECT 
                id,
                titulo AS carrera_titulo,
                descripcion AS carrera_descripcion,
                link_malla_curricular,
                imagen AS carrera_imagen
            FROM carrera
            WHERE lower(regexp_replace(titulo, '[^a-z0-9]+', '-', 'g')) = :slug
            LIMIT 1
        ";
        return $this->ejecutarConsultaPersonalizada($sql, ['slug' => $slug]);
    }

    public function obtenerParrafosPorCarrera($carreraId)
    {
        $sql = "
            SELECT 
                id AS parrafo_id,
                numero_parrafo,
                contenido AS parrafo_contenido
            FROM carrera_parrafos
            WHERE carrera_id = :carreraId
            ORDER BY numero_parrafo ASC
        ";
        return $this->ejecutarConsultaPersonalizada($sql, ['carreraId' => $carreraId]);
    }

    public function obtenerTurnosPorCarrera($carreraId)
    {
        $sql = "
            SELECT 
                id AS turno_id,
                turno
            FROM carrera_turnos
            WHERE carrera_id = :carreraId
            ORDER BY id ASC
        ";
        return $this->ejecutarConsultaPersonalizada($sql, ['carreraId' => $carreraId]);
    }

    public function obtenerNivelesPorCarrera($carreraId)
    {
        $sql = "
            SELECT 
                id AS nivel_id,
                nivel,
                duracion,
                diploma
            FROM carrera_niveles_academicos
            WHERE carrera_id = :carreraId
            ORDER BY id ASC
        ";
        return $this->ejecutarConsultaPersonalizada($sql, ['carreraId' => $carreraId]);
    }

    public function obtenerNucleosPorCarrera($carreraId)
    {
        $sql = "
            SELECT 
                n.id AS nucleo_id,
                n.nombre AS nucleo_nombre
            FROM carrera_nucleos AS cn
            LEFT JOIN nucleos AS n ON n.id = cn.nucleo_id
            WHERE cn.carrera_id = :carreraId
            ORDER BY n.id ASC
        ";
        return $this->ejecutarConsultaPersonalizada($sql, ['carreraId' => $carreraId]);
    }
};