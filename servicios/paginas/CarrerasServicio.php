<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/CarrerasModelo.php');

/**
 * Servicio para la página de Carreras.
 *
 * Proporciona métodos para obtener y organizar los datos completos de una carrera
 * desde el modelo, estructurados para su presentación en la vista.
 */
class CarrerasServicio
{
    /**
     * @var \Modelo\Paginas\CarrerasModelo Instancia del modelo de Carreras.
     */
    private $modelo_carreras;

    /**
     * Constructor.
     *
     * Inicializa el modelo de Carreras.
     */
    public function __construct()
    {
        $this->modelo_carreras = new \Modelo\Paginas\CarrerasModelo();
    }

    /**
     * Obtiene los datos completos de una carrera según su slug.
     *
     * @param string $slug Identificador único de la carrera.
     * @return array|null Retorna un array con la información de la carrera
     *                    incluyendo parrafos, turnos, niveles y nucleos,
     *                    o null si no se encuentra la carrera.
     */
    public function obtenerDatosCarrera($slug)
    {
        $datos_carrera = $this->modelo_carreras->obtenerCarreraCompletaPorSlug($slug);
        if (!$datos_carrera) return null;

        $informacion_carrera = null;
        $arreglo_parrafos = [];
        $arreglo_turnos = [];
        $arreglo_niveles = [];
        $arreglo_nucleos = [];

        foreach ($datos_carrera as $fila) {
            if ($informacion_carrera === null) {
                $informacion_carrera = [
                    'id' => $fila['id'],
                    'titulo' => $fila['carrera_titulo'],
                    'descripcion' => $fila['carrera_descripcion'],
                    'link_malla_curricular' => $fila['link_malla_curricular']
                ];
            }

            if ($fila['parrafo_id'] !== null && !isset($arreglo_parrafos[$fila['parrafo_id']])) {
                $arreglo_parrafos[$fila['parrafo_id']] = [
                    'numero_parrafo' => $fila['numero_parrafo'],
                    'contenido' => $fila['parrafo_contenido']
                ];
            }

            if ($fila['turno_id'] !== null && !in_array($fila['turno'], $arreglo_turnos)) {
                $arreglo_turnos[] = $fila['turno'];
            }

            if ($fila['nivel_id'] !== null && !isset($arreglo_niveles[$fila['nivel_id']])) {
                $arreglo_niveles[$fila['nivel_id']] = [
                    'nivel' => $fila['nivel'],
                    'duracion' => $fila['duracion'],
                    'diploma' => $fila['diploma']
                ];
            }

            if ($fila['nucleo_id'] !== null && !isset($arreglo_nucleos[$fila['nucleo_id']])) {
                $arreglo_nucleos[$fila['nucleo_id']] = [
                    'id' => $fila['nucleo_id'],
                    'nombre' => $fila['nucleo_nombre']
                ];
            }
        }

        return [
            'id' => $informacion_carrera['id'],
            'titulo' => $informacion_carrera['titulo'],
            'descripcion' => $informacion_carrera['descripcion'],
            'link_malla_curricular' => $informacion_carrera['link_malla_curricular'],
            'parrafos' => array_values($arreglo_parrafos),
            'turnos' => $arreglo_turnos,
            'niveles' => array_values($arreglo_niveles),
            'nucleos' => array_values($arreglo_nucleos),
        ];
    }
}