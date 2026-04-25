<?php
/**
 * Controlador de la página de Núcleos.
 *
 * Obtiene los datos de los núcleos y extensiones para mostrarlos en la vista.
 */
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/NucleosServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');

class NucleosControlador extends BaseControlador {

    public function index(): void {
        $servicio = new \Servicios\Paginas\NucleosServicio();
        $servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();

        $data_nucleos = $servicio->obtenerTodosLosNucleos();
        $data_header = $servicio_plantilla->obtenerDatosMenu('Header');
        $data_footer = $servicio_plantilla->obtenerDatosMenu('Footer');

        $this->establecerHead([
            "title" => "Nuestros Núcleos - UNEXCA",
            "styles" => ["@estilos/paginas/nucleos.css"],
            "meta" => [
                "description" => "Conoce los diferentes núcleos y extensiones de la UNEXCA.",
                "keywords" => "UNEXCA, núcleos, sedes, extensiones, universidad",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/nucleos.php'));

        $this->renderizar([
            'data_nucleos' => $data_nucleos,
            'data_header'  => $data_header,
            'data_footer'  => $data_footer
        ]);
    }
}
