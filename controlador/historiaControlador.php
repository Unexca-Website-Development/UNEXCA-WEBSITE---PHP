<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');

class HistoriaControlador extends BaseControlador {

    public function index(): void {

        $servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();
        $data_header = $servicio_plantilla->obtenerDatosMenu('Header');
        $data_footer = $servicio_plantilla->obtenerDatosMenu('Footer');

        $this->establecerHead([
            "title" => "Historia - UNEXCA",
            "meta" => [
                "description" => "Conoce la historia de la UNEXCA y sus orígenes.",
                "keywords" => "UNEXCA, historia, universidad, educación, fundación",
            ],
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/historia.php'));

        $this->renderizar([
            'data_header'  => $data_header,
            'data_footer'  => $data_footer
        ]);
    }
}