<?php
namespace Modelo\Paginas;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

/**
 * Clase AutoridadesModelo
 *
 * Representa la tabla 'autoridades_academicas' y proporciona métodos CRUD
 * para obtener información de las autoridades académicas.
 *
 * @package Modelo\Paginas
 */
class AutoridadesModelo extends \Modelo\BaseModelo
{
    /**
     * Obtiene todas las autoridades académicas
     *
     * @return array Lista de autoridades
     * @throws \Exception Si falla la consulta
     */
    public function obtenerAutoridades()
    {
        return $this->obtenerTodos('autoridades_academicas');
    }
}
