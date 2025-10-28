<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class AutoridadesModelo extends \Modelo\BaseModelo
{
    public function obtenerAutoridades()
    {
        return $this->obtenerTodos('autoridades_academicas');
    }
};