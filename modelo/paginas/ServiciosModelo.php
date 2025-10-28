<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class ServiciosModelo extends \Modelo\BaseModelo
{
    public function obtenerServicios()
    {
        return $this->obtenerTodos('servicios');
    }
};