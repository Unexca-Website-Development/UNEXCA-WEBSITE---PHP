<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/NucleosServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');

class NucleosControlador extends BaseControlador {
    private $servicio_nucleos;
    private $servicio_plantilla;

    public function __construct() {
        $this->servicio_nucleos = new \Servicios\Paginas\NucleosServicio();
        $this->servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();
    }

    /**
     * Muestra la vista principal (listado de nucleos)
     */
    public function index(): void {
        $data_nucleos = $this->servicio_nucleos->obtenerTodos();
        $data_header = $this->servicio_plantilla->obtenerDatosMenu('Header');
        $data_footer = $this->servicio_plantilla->obtenerDatosMenu('Footer');

        $this->establecerHead([
            "title" => "Nuestros Núcleos - UNEXCA",
            "styles" => ["@estilos/paginas/nucleos.css"],
        ]);
        $this->establecerVista(colocar_ruta_sistema('@paginas/nucleos.php'));
        $this->renderizar([
            'data_nucleos' => $data_nucleos,
            'data_header'  => $data_header,
            'data_footer'  => $data_footer
        ]);
    }
}