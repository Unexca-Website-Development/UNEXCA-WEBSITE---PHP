<?php

namespace Servicios\Plantilla;

require_once colocar_ruta_sistema('@modelo/plantilla/PlantillaModelo.php');

/**
 * Servicio de plantilla.
 *
 * Proporciona métodos para obtener y procesar datos de menús desde el modelo
 * de plantilla, preparando la estructura de enlaces para la vista.
 */
class PlantillaDefaultServicio
{
    /**
     * @var \Modelo\Plantilla\PlantillaModelo Instancia del modelo de plantilla.
     */
    private $modelo;

    /**
     * Constructor.
     *
     * Inicializa el modelo de plantilla.
     */
    public function __construct()
    {
        $this->modelo = new \Modelo\Plantilla\PlantillaModelo();
    }

    /**
     * Obtiene los datos de un menú por su nombre.
     *
     * Procesa enlaces estáticos y dinámicos y los organiza en un array
     * listo para ser usado en la vista de navegación.
     *
     * @param string $nombre Nombre del menú a obtener.
     * @return array Estructura del menú con enlaces y submenús.
     */
    public function obtenerDatosMenu($nombre)
    {
        $menu = $this->modelo->obtenerMenuPorNombre($nombre);
        if (!$menu) return [];

        $enlaces = $this->modelo->obtenerEnlacesJerarquicos($menu['id']);
        $resultado = [];

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
