<?php
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class ServiciosModelo extends BaseModelo
{
    public function obtenerServicios()
    {
        return $this->obtenerTodos('servicios');
    }
};