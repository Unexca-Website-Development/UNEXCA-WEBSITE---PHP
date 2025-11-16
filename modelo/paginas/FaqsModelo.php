<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

/**
 * Clase FaqsModelo
 *
 * Representa la tabla 'faqs' y proporciona métodos CRUD específicos
 * para obtener preguntas frecuentes.
 *
 * @package Modelo\Paginas
 */
class FaqsModelo extends \Modelo\BaseModelo
{
    /**
     * Obtiene todas las preguntas frecuentes
     *
     * @return array Lista de FAQs
     * @throws \Exception Si falla la consulta
     */
    public function obtenerFaqs()
    {
        return $this->obtenerTodos('faqs');
    }
}
