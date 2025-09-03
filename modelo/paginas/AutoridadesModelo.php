<?php
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class AutoridadesModelo extends BaseModelo
{
    public function obtenerAutoridades()
    {
        return $this->obtenerTodos('autoridades_academicas');
    }
};