<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

/**
 * Clase ServiciosModelo
 *
 * Representa la tabla 'servicios' y proporciona métodos CRUD específicos.
 *
 * @package Modelo\Paginas
 */
class ServiciosModelo extends \Modelo\BaseModelo
{
    /**
     * Obtiene todos los servicios
     *
     * @return array Lista de servicios
     * @throws \Exception Si falla la consulta
     */
    public function obtenerServicios()
    {
        return $this->obtenerTodos('servicios');
    }
}
