<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/ServiciosServicio.php');

class ServiciosControlador extends BaseControlador {

    public function index(): void {
        $servicio = new \Servicios\Paginas\ServiciosServicio();
        $data_servicios = $servicio->obtenerDatosServicios();

        $this->establecerHead([
            "title" => "Servicios - UNEXCA",
            "styles" => [
                "@estilos/componentes/desplegable.css"
            ],
            "meta" => [
                "description" => "Página de servicios ofrecidos por la UNEXCA.",
                "keywords" => "UNEXCA, servicios, educación, universidad, asesoría",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/servicios.php'));

        $this->renderizar([
            'data_servicios' => $data_servicios
        ]);
    }
}
