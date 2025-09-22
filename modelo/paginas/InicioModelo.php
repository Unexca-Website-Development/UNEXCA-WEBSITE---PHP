<?php
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class InicioModelo extends BaseModelo
{
    public function obtenerCarrerasSimples()
    {
        return $this->obtenerTodos('carrera');
    }
};