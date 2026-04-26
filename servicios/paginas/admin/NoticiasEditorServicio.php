<?php

namespace Servicios\Paginas\Admin;

require_once colocar_ruta_sistema('@modelo/paginas/admin/NoticiasEditorModelo.php');
require_once colocar_ruta_sistema('@servicios/utilidadesNoticiasEditor.php');

/**
 * Servicio para la gestión del editor de noticias.
 */
class NoticiasEditorServicio {

    private $modelo;

    public function __construct()
    {
        $this->modelo = new \Modelo\Paginas\Admin\NoticiasEditorModelo();
    }

    /**
     * Guarda una noticia nueva o actualiza una existente.
     * 
     * @param array $data Datos crudos del editor.
     * @return array|bool Resultado de la operación.
     */
    public function guardarNoticia(array $data)
    {
        $id = $data['id'] ?? null;

        $noticia = [
            'titulo_principal'   => $data['titulo_principal'] ?? '',
            'descripcion_corta'  => $data['descripcion_corta'] ?? '',
            'imagen_principal'   => !empty($data['imagen_principal']) ? $data['imagen_principal'] : 'noticias/default.jpg',
            'descripcion_imagen' => $data['descripcion_imagen'] ?? null,
            'url'                => !empty($data['url']) ? $data['url'] : normalizar_texto($data['titulo_principal'] ?? 'noticia-' . time()),
            'estado'             => $data['estado'] ?? 'borrador',
            'fecha_publicacion'  => !empty($data['fecha_publicacion']) ? $data['fecha_publicacion'] : date('Y-m-d H:i:s')
        ];

        $bloques = isset($data['bloques']) ? prepararBloquesJSON($data['bloques']) : [];

        if ($id) {
            // Actualizar existente
            $this->modelo->actualizarNoticia($id, $noticia);
            
            if ($this->modelo->reemplazarContenido($id, $bloques)) {
                return $id;
            }
            
            return false;
        } else {
            // Crear nueva
            $estructura = [
                'noticia'   => $noticia,
                'contenido' => $bloques
            ];
            return $this->modelo->guardarNoticiaCompleta($estructura);
        }
    }

    /**
     * Obtiene todas las noticias registradas.
     */
    public function listarNoticias()
    {
        return $this->modelo->obtenerTodas();
    }

    /**
     * Carga una noticia por su ID.
     */
    public function cargarNoticia($id)
    {
        return $this->modelo->cargarNoticia($id);
    }

    /**
     * Elimina una noticia por su ID.
     */
    public function eliminarNoticia($id)
    {
        return $this->modelo->eliminarNoticia($id);
    }
}