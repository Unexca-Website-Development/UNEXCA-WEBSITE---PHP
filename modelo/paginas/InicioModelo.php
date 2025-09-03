<?php
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class inicioModelo extends BaseModelo
{
    public function obtenerCarrerasSimples()
    {
        return $this->obtenerTodos('carrera');
    }
};