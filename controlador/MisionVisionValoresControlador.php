<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');

class MisionVisionValoresControlador extends BaseControlador {

    public function index(): void {

        $servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();

        $data_header = $servicio_plantilla->obtenerDatosMenu('Header');
        $data_footer = $servicio_plantilla->obtenerDatosMenu('Footer');

        $this->establecerHead([
            "title" => "Misión, Visión y Valores - UNEXCA",
            "meta" => [
                "description" => "Conoce la misión, visión y valores que guían a la UNEXCA como institución educativa.",
                "keywords" => "UNEXCA, misión, visión, valores, universidad, educación",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/mision_vision_valores.php'));

        $this->renderizar([
            'data_header'  => $data_header,
            'data_footer'  => $data_footer
        ]);
    }
}
