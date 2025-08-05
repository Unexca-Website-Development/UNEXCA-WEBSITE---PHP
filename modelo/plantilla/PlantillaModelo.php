<?php
require_once colocar_ruta_sistema('@modelo/baseModelo.php');

class PlantillaModelo extends BaseModelo
{
    public function obtenerHeaderLinks()
    {
        return $this->obtenerTodos('header_links');
    }

    public function obtenerFooterSecciones()
    {
        return $this->obtenerTodos('footer_secciones');
    }

    public function obtenerFooterLinks()
    {
        return $this->obtenerTodos('footer_links');
    }
}