<?php
require_once colocar_ruta_sistema('@modelo/baseModelo.php');

class ServiciosModelo extends BaseModelo
{
    public function obtenerServicios()
    {
        return $this->obtenerTodos('servicios');
    }
};