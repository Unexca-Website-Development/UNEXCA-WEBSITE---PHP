<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');

class HistoriaControlador extends BaseControlador {

    public function index(): void {
        $this->establecerHead([
            "title" => "Historia - UNEXCA",
            "meta" => [
                "description" => "Conoce la historia de la UNEXCA y sus orígenes.",
                "keywords" => "UNEXCA, historia, universidad, educación, fundación",
            ],
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/historia.php'));

        $this->renderizar();
    }
}