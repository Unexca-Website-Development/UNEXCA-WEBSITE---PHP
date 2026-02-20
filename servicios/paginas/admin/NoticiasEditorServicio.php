<?php

namespace Servicios\Admin\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/NoticiasEditorModelo.php');

class NoticiasEditorServicio {

    private $modelo_noticias_editor;

    public function __construct()
    {
        $this->modelo_noticias_editor = new \Modelo\Paginas\Admin\NoticiasEditorModelo();
    }

    public function guardarNoticia($data)
    {
        $estructura = [
            'noticia' => [
                'titulo_principal'   => $data['titulo_principal'] ?? null,
                'descripcion_corta'  => $data['descripcion_corta'] ?? null,
                'imagen_principal'   => $data['imagen_principal'] ?? null,
                'descripcion_imagen' => $data['descripcion_imagen'] ?? null,
                'url'                => $data['url'] ?? null,
                'estado'             => $data['estado'] ?? 'borrador',
                'fecha_publicacion'  => $data['fecha_publicacion'] ?? null
            ],
            'contenido' => []
        ];

        if (!empty($data['bloques']) && is_array($data['bloques'])) {
            $posicion = 1;

            foreach ($data['bloques'] as $bloque) {
                $estructura['contenido'][] = [
                    'tipo_bloque' => $bloque['tipo_bloque'] ?? null,
                    'datos'       => isset($bloque['datos']) ? json_encode($bloque['datos']) : json_encode([]),
                    'posicion'    => $posicion++
                ];
            }
        }

        //return $this->modelo_noticias_editor->guardarNoticiaCompleta($estructura);
    }


    public function eliminarNoticia($id){
        //
    }

    public function cargarNoticia($id){
        //
    }
}