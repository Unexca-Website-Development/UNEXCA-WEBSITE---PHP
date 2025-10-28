<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class InicioModelo extends \Modelo\BaseModelo
{
    public function obtenerCarrerasSimples()
    {
        return $this->obtenerTodos('carrera');
    }
};