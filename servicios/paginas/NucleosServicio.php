<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/NucleosModelo.php');

/**
 * Servicio para la consulta de Núcleos y Extensiones Institucionales para la vista pública.
 */
class NucleosServicio {
    private $modelo_nucleos;

    public function __construct() {
        $this->modelo_nucleos = new \Modelo\Paginas\NucleosModelo();
    }

    /**
     * Obtiene el listado completo de núcleos para la vista pública
     *
     * @return array
     */
    public function obtenerTodos() {
        return $this->modelo_nucleos->obtenerNucleos();
    }
}