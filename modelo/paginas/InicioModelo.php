<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

/**
 * Clase InicioModelo
 *
 * Representa la tabla 'carrera' y proporciona métodos CRUD específicos
 * para obtener información simplificada de las carreras.
 *
 * @package Modelo\Paginas
 */
class InicioModelo extends \Modelo\BaseModelo
{
    /**
     * Obtiene todas las carreras
     *
     * @return array Lista de carreras
     * @throws \Exception Si falla la consulta
     */
    public function obtenerCarrerasSimples()
    {
        return $this->obtenerTodos('carrera');
    }
}
