<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/InicioServicio.php');

class InicioControlador extends BaseControlador {

    public function index(): void {
        $servicio = new \Servicios\Paginas\InicioServicio();
        $data_carrera = $servicio->obtenerDatosCarreras();

        $this->establecerHead([
            "title" => "Inicio - UNEXCA",
            "styles" => [
                "@estilos/paginas/inicio.css",
                "@estilos/componentes/botones.css"
            ],
            "meta" => [
                "description" => "Página de inicio de la UNEXCA.",
                "keywords" => "UNEXCA, universidad, inicio",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/inicio.php'));

        $this->renderizar([
            'data_carrera' => $data_carrera
        ]);
    }
}
