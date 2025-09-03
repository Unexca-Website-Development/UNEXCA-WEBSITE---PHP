<?php
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class FaqsModelo extends BaseModelo
{
    public function obtenerFaqs()
    {
        return $this->obtenerTodos('faqs');
    }
};