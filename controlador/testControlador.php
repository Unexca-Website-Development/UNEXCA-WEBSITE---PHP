<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');

class TestControlador extends BaseControlador {

    public function index(): void {
        $this->establecerHead([
            "title" => "Api Test",
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/test.php'));

        $this->renderizar();
    }
}
