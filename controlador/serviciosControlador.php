<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/ServiciosServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');

class ServiciosControlador extends BaseControlador {

    public function index(): void {
        $servicio = new \Servicios\Paginas\ServiciosServicio();
        $servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();

        $data_servicios = $servicio->obtenerDatosServicios();
        $data_header = $servicio_plantilla->obtenerDatosMenu('Header');
        $data_footer = $servicio_plantilla->obtenerDatosMenu('Footer');

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
            'data_servicios' => $data_servicios,
            'data_header'  => $data_header,
            'data_footer'  => $data_footer
        ]);
    }
}
