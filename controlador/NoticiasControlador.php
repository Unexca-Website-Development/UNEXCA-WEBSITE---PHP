<?php

require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@modelo/paginas/NoticiasModelo.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');

class NoticiasControlador extends BaseControlador {

    public function mostrar(array $params = []): void {
        $url = $params['url'] ?? '';

        if (empty($url)) {
            \Servicios\Nucleo\ControladorErroresHTTP::error404();
            return;
        }

        $modelo = new \NoticiasModelo();
        $noticiaData = $modelo->obtenerPorUrl($url);

        if (!$noticiaData) {
            \Servicios\Nucleo\ControladorErroresHTTP::error404();
            return;
        }

        $servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();
        $data_header = $servicio_plantilla->obtenerDatosMenu('Header');
        $data_footer = $servicio_plantilla->obtenerDatosMenu('Footer');

        $this->establecerHead([
            "title" => $noticiaData['noticia']['titulo_principal'] . " - UNEXCA",
            "styles" => [
                "@estilos/paginas/general.css",
                "@estilos/paginas/error.css" 
            ],
            "meta" => [
                "description" => $noticiaData['noticia']['descripcion_corta'],
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@vista/paginas/noticia.php'));

        $this->renderizar([
            'noticia' => $noticiaData['noticia'],
            'contenido' => $noticiaData['contenido'],
            'data_header' => $data_header,
            'data_footer' => $data_footer
        ]);
    }
}
