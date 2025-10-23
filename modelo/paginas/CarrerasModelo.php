<?php
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

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
                slug
            FROM carrera
            WHERE slug = :slug
            LIMIT 1;
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

    public function obtenerCarreraCompletaPorSlug($slug)
    {
        $sql = "
            SELECT 
                c.id,
                c.titulo AS carrera_titulo,
                c.descripcion AS carrera_descripcion,
                c.link_malla_curricular,
                c.slug,
                cp.id AS parrafo_id,
                cp.numero_parrafo,
                cp.contenido AS parrafo_contenido,
                ct.id AS turno_id,
                ct.turno,
                cna.id AS nivel_id,
                cna.nivel,
                cna.duracion,
                cna.diploma,
                n.id AS nucleo_id,
                n.nombre AS nucleo_nombre
            FROM carrera c
            LEFT JOIN carrera_parrafos cp ON c.id = cp.carrera_id
            LEFT JOIN carrera_turnos ct ON c.id = ct.carrera_id
            LEFT JOIN carrera_niveles_academicos cna ON c.id = cna.carrera_id
            LEFT JOIN carrera_nucleos cn ON c.id = cn.carrera_id
            LEFT JOIN nucleos n ON cn.nucleo_id = n.id
            WHERE c.slug = :slug
            ORDER BY 
                cp.numero_parrafo ASC,
                ct.id ASC,
                cna.id ASC,
                n.id ASC
        ";
        return $this->ejecutarConsultaPersonalizada($sql, ['slug' => $slug]);
    }
};