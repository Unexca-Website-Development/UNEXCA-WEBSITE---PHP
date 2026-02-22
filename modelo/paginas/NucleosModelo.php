<?php
namespace Modelo\Paginas;
require_once colocar_ruta_sistema('@modelo/BaseModelo.php');
/**
 * Clase NucleosModelo
 *
 * Representa la tabla 'nucleos' y proporciona métodos CRUD
 * para la gestión de núcleos y extensiones institucionales.
 *
 * @package Modelo\Paginas
 */
class NucleosModelo extends \Modelo\BaseModelo
{
    /**
     * Obtiene todos los núcleos y extensiones ordenados
     *
     * @return array
     */
    public function obtenerNucleos()
    {
        return $this->obtenerTodos('nucleos', [], 'nombre ASC');
    }
    /**
     * Obtiene un núcleo por su ID
     *
     * @param int $id
     * @return array|false
     */
    public function obtenerNucleoPorId($id)
    {
        return $this->obtenerPorId('nucleos', $id);
    }
    /**
     * Inserta un nuevo núcleo
     *
     * @param array $data
     * @return string|false
     */
    public function agregarNucleo($data)
    {
        return $this->insertar('nucleos', $data);
    }
    /**
     * Actualiza un núcleo existente
     *
     * @param array $data
     * @param int $id
     * @return int
     */
    public function editarNucleo($data, $id)
    {
        return $this->actualizar('nucleos', $data, $id);
    }
    /**
     * Elimina un núcleo
     *
     * @param int $id
     * @return int
     */
    public function borrarNucleo($id)
    {
        return $this->eliminar('nucleos', $id);
    }
}