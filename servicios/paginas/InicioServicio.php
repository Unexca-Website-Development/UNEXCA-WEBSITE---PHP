<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/InicioModelo.php');

/**
 * Servicio para la página de inicio.
 *
 * Proporciona métodos para obtener y procesar los datos de inicio, en particular
 * la información de carreras, para ser consumidos por la vista.
 */
class InicioServicio
{
    /**
     * @var \Modelo\Paginas\InicioModelo Instancia del modelo de inicio.
     */
    private $modelo_inicio;

    /**
     * Constructor.
     *
     * Inicializa el modelo de inicio.
     */
    public function __construct()
    {
        $this->modelo_inicio = new \Modelo\Paginas\InicioModelo();
    }

    /**
     * Obtiene los datos de las carreras.
     *
     * Procesa la información de la base de datos y la convierte en un array
     * listo para ser usado en la vista de inicio.
     *
     * @return array Lista de carreras con título, descripción, enlace e imagen.
     */
    public function obtenerDatosCarreras()
    {
        $carreras_lista = $this->modelo_inicio->obtenerCarrerasSimples();
        $carreras_array = [];

        foreach ($carreras_lista as $carrera) {
            $link_carrera = colocar_enlace('carrera', ['slug' => $carrera['slug']]);
            $carreras_array[] = [
                "titulo"      => $carrera['titulo'],
                "descripcion" => $carrera['descripcion'],
                "links"       => $link_carrera,
                "img"         => $carrera['imagen'],
            ];
        }

        return $carreras_array;
    }
}

