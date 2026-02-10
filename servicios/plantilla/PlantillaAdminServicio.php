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
    public function obtenerMenuControl()
    {
        return [
            ['titulo' => 'Noticias', 'url' => 'admin/noticias', 'icon' => 'noticias'],
            ['titulo' => 'Autoridades', 'url' => 'admin/autoridades', 'icon' => 'autoridades'],
            ['titulo' => 'Núcleos y extensiones', 'url' => 'admin/nucleos', 'icon' => 'nucleos'],
            ['titulo' => 'Opciones generales', 'url' => 'admin/opciones', 'icon' => 'opciones'],
        ];
    }
}
