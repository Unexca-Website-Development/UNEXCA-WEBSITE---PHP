<?php
require_once colocar_ruta_sistema('@modelo/baseModelo.php');

class FaqsModelo extends BaseModelo
{
    public function obtenerFaqs()
    {
        return $this->obtenerTodos('faqs');
    }
};