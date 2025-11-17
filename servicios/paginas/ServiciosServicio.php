<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/ServiciosModelo.php');

/**
 * Servicio para la página de servicios.
 *
 * Proporciona métodos para obtener y procesar los datos de servicios desde
 * el modelo, preparándolos para ser consumidos por la vista.
 */
class ServiciosServicio
{
    /**
     * @var \Modelo\Paginas\ServiciosModelo Instancia del modelo de servicios.
     */
    private $modelo_servicios;

    /**
     * Constructor.
     *
     * Inicializa el modelo de servicios.
     */
    public function __construct()
    {
        $this->modelo_servicios = new \Modelo\Paginas\ServiciosModelo();
    }

    /**
     * Obtiene los datos de todos los servicios.
     *
     * Procesa la información desde la base de datos y la convierte en un array
     * listo para ser usado en la vista.
     *
     * @return array Lista de servicios con id, título y contenido.
     */
    public function obtenerDatosServicios()
    {
        $servicios_lista = $this->modelo_servicios->obtenerServicios();
        $servicios_array = [];

        foreach ($servicios_lista as $servicio) {
            $servicios_array[] = [
                "id" => $servicio['id'],
                "titulo" => $servicio['servicio'],
                "contenido" => $servicio['respuesta'],
            ];
        }

        return $servicios_array;
    }
}