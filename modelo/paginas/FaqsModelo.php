<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

class FaqsModelo extends \Modelo\BaseModelo
{
    public function obtenerFaqs()
    {
        return $this->obtenerTodos('faqs');
    }
};