<?php
namespace Servicios\Plantilla;

require_once colocar_ruta_sistema('@modelo/plantilla/PlantillaModelo.php');

class PlantillaServicio
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new \Modelo\Plantilla\PlantillaModelo();
    }

    public function obtenerDatosMenu($nombre)
    {
        $menu = $this->modelo->obtenerMenuPorNombre($nombre);
        if (!$menu) return [];

        $enlaces = $this->modelo->obtenerEnlacesJerarquicos($menu['id']);
        $resultado = [];

        // Enlaces estáticos
        foreach ($enlaces['estaticos'] as $fila) {
            $id = 'e_' . $fila['padre_id'];
            if (!isset($resultado[$id])) {
                $resultado[$id] = [
                    'titulo'  => $fila['padre_titulo'] ?? '',
                    'url'     => !empty($fila['padre_url']) ? colocar_enlace($fila['padre_url']) : '#',
                    'submenu' => []
                ];
            }

            if (!empty($fila['hijo_id'])) {
                $resultado[$id]['submenu'][$fila['hijo_titulo'] ?? ''] = !empty($fila['hijo_url']) ? colocar_enlace($fila['hijo_url']) : '#';
            }
        }

        // Enlaces dinámicos
        foreach ($enlaces['dinamicos'] as $fila) {
            $id = 'd_' . $fila['id'];
            $padre_id = $fila['padre_id'] ? 'e_' . $fila['padre_id'] : null;

            $url = !empty($fila['url'])
                ? colocar_enlace($fila['tabla_origen'], ['nombre' => $fila['url']])
                : '#';

            if ($padre_id && isset($resultado[$padre_id])) {
                $resultado[$padre_id]['submenu'][$fila['titulo'] ?? '#'] = $url;
            } else {
                $resultado[$id] = [
                    'titulo'  => $fila['titulo'] ?? '#',
                    'url'     => $url,
                    'submenu' => []
                ];
            }
        }

        // Reindexar por título
        $final = [];
        foreach ($resultado as $item) {
            $final[$item['titulo']] = [
                'url'     => $item['url'],
                'submenu' => $item['submenu']
            ];
        }

        return $final;
    }
}