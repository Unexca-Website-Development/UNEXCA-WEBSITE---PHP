<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');

class MisionVisionValoresControlador extends BaseControlador {

    public function index(): void {
        $this->establecerHead([
            "title" => "Misión, Visión y Valores - UNEXCA",
            "meta" => [
                "description" => "Conoce la misión, visión y valores que guían a la UNEXCA como institución educativa.",
                "keywords" => "UNEXCA, misión, visión, valores, universidad, educación",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/mision_vision_valores.php'));

        $this->renderizar();
    }
}
