<?php
namespace Servicios\Plantilla;

/**
 * Servicio para la gestión del Menú de Control Administrativo.
 */
class PlantillaAdminServicio
{
    /**
     * Retorna las opciones del menú administrativo.
     * Según RF-01 de Menu de Control.html
     * 
     * @return array
     */
    public function obtenerMenuControl($slug_seccion = null)
    {
        $menu = 
        [
            'inicio' => [
                'titulo' => 'Inicio', 
                'url' => colocar_enlace('admin', ['seccion' => 'inicio']), 
                'icon' => 'inicio'
            ],
            'noticias' => [
                'titulo' => 'Noticias', 
                'url' => colocar_enlace('admin', ['seccion' => 'noticias']), 
                'icon' => 'noticias'
            ],
            'autoridades' => [
                'titulo' => 'Autoridades', 
                'url' => colocar_enlace('admin', ['seccion' => 'autoridades']), 
                'icon' => 'autoridades'
            ],
            'nucleos' => [
                'titulo' => 'Núcleos y extensiones', 
                'url' => colocar_enlace('admin', ['seccion' => 'nucleos']), 
                'icon' => 'nucleos'
            ],
            'opciones' => [
                'titulo' => 'Opciones generales', 
                'url' => colocar_enlace('admin', ['seccion' => 'opciones']), 
                'icon' => 'opciones'
            ]
        ];

        if ($slug_seccion === null) {
            return null;
        }

        if (!isset($menu[$slug_seccion])) {
            return null;
        }

        return $menu;
    }
}
