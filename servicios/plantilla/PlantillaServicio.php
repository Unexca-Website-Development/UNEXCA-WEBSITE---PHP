<?php
require_once colocar_ruta_sistema('@modelo/plantilla/PlantillaModelo.php');

class PlantillaServicio {
    private $modelo;

    public function __construct()
    {
        $this->modelo = new PlantillaModelo();    
    }

    /**
     * Transforma los datos del footer en un arreglo agrupado por secciones
     */
    public function obtenerDatosFooter()
    {
        // Obtener datos crudos desde el modelo
        $secciones = $this->modelo->obtenerFooterSecciones(); // Ej: [ ['id' => 1, 'titulo' => 'Acerca de'], ... ]
        $links     = $this->modelo->obtenerFooterLinks();     // Ej: [ ['texto' => 'Historia', 'url' => '...', 'seccion_id' => 1], ... ]

        // Inicializar arreglo agrupador por seccion
        $agrupado = [];

        foreach ($secciones as $seccion) {
            $agrupado[$seccion['id']] = [
                'title' => $seccion['titulo'],
                'links' => [], // Se llenara con los links de esa seccion
            ];
        }

        // Asociar cada link a su seccion correspondiente
        foreach ($links as $link) {
            $id = $link['seccion_id'];

            if (isset($agrupado[$id])) {
                $agrupado[$id]['links'][$link['texto']] = procesar_enlace($link['url']);
            }
        }

        // Reindexar el array (convertir claves numericas secuenciales)
        return array_values($agrupado);
    }

    /**
     * Transforma los links del header en un arreglo jerarquico padre/hijo
     */
    public function obtenerDatosHeader()
    {
        $links = $this->modelo->obtenerHeaderLinks(); // Todos los links, incluyendo padres e hijos

        $menu_padres = [];
        $menu_hijos  = [];

        foreach ($links as $link) {
            if (is_null($link['id_padre'])) {
                $menu_padres[$link['id']] = [
                    'titulo'  => $link['titulo'],
                    'url'     => procesar_enlace($link['url']),
                    'submenu' => [],
                ];
            } else {
                $menu_hijos[] = $link;
            }
        }

        foreach ($menu_hijos as $link) {
            $idPadre = $link['id_padre'];

            if (isset($menu_padres[$idPadre])) {
                $menu_padres[$idPadre]['submenu'][$link['titulo']] = procesar_enlace($link['url']);
            }
        }

        $resultado = [];
        foreach ($menu_padres as $link) {
            $resultado[$link['titulo']] = [
                'url'     => $link['url'],
                'submenu' => $link['submenu'],
            ];
        }

        return $resultado;
    }
}

