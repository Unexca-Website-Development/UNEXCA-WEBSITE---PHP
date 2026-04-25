<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/NucleosModelo.php');

/**
 * Servicio para la página de núcleos.
 *
 * Proporciona métodos para obtener y procesar los datos de los núcleos
 * para ser consumidos por la vista.
 */
class NucleosServicio
{
    /**
     * @var \Modelo\Paginas\NucleosModelo Instancia del modelo de núcleos.
     */
    private $modelo_nucleos;

    /**
     * Constructor.
     *
     * Inicializa el modelo de núcleos.
     */
    public function __construct()
    {
        $this->modelo_nucleos = new \Modelo\Paginas\NucleosModelo();
    }

    /**
     * Obtiene todos los núcleos procesados.
     *
     * @return array Lista de núcleos con sus datos.
     */
    public function obtenerTodosLosNucleos()
    {
        return $this->modelo_nucleos->obtenerNucleos();
    }
}
