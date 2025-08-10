<?php
require_once colocar_ruta_sistema('@modelo/paginas/ServiciosModelo.php');

class ServiciosServicio
{
    private $modelo_servicios;

    public function __construct()
    {
        $this->modelo_servicios = new ServiciosModelo();
    }

    public function obtenerDatosServicios()
    {
        $servicios_lista = $this->modelo_servicios->obtenerServicios();
        $servicios_array = [];

        foreach ($servicios_lista as $servicio) {

            $servicios_array[] = [
                "servicio" => $servicio['servicio'],
                "respuesta" => $servicio['respuesta'],
            ];
        }
        
        return $servicios_array;
    }
};
