<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/AutoridadesModelo.php');

/**
 * Servicio para la página de Autoridades.
 *
 * Proporciona métodos para obtener los datos de las autoridades desde el modelo,
 * estructurados para su presentación en la vista.
 */
class AutoridadesServicio
{
    /**
     * @var \Modelo\Paginas\AutoridadesModelo Instancia del modelo de Autoridades.
     */
    private $modelo_autoridades;

    /**
     * Constructor.
     *
     * Inicializa el modelo de Autoridades.
     */
    public function __construct()
    {
        $this->modelo_autoridades = new \Modelo\Paginas\AutoridadesModelo();
    }

    /**
     * Obtiene los datos de todas las autoridades.
     *
     * @return array Retorna un array de autoridades con nombre, cargo e imagen.
     */
    public function obtenerDatosAutoridades()
    {
        $autoridades_lista = $this->modelo_autoridades->obtenerAutoridades();
        $autoridades_array = [];

        foreach ($autoridades_lista as $autoridad) {
            $autoridades_array[] = [
                "nombre" => $autoridad['nombre'],
                "cargo" => $autoridad['cargo'],
                "imagen" => $autoridad['imagen'],
            ];
        }

        return $autoridades_array;
    }
}