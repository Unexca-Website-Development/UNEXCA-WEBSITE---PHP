<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/ContactosServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');

class ContactosControlador extends BaseControlador {

    public function index(): void {
        $servicio = new \Servicios\Paginas\ContactosServicio();
        $servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();

        $data_contactos_admin = $servicio->obtenerContactosDirectivos();
        $data_contactos_coords = $servicio->obtenerContactosCoordinadores();

        $data_header = $servicio_plantilla->obtenerDatosMenu('Header');
        $data_footer = $servicio_plantilla->obtenerDatosMenu('Footer');

        $this->establecerHead([
            "title" => "Contactos - UNEXCA",
            "styles" => [
                "@estilos/paginas/contactos.css",
            ],
            "meta" => [
                "description" => "",
                "keywords" => "UNEXCA, universidad, contactos"
            ],
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/contactos.php'));

        $this->renderizar([
            'data_contactos_admin' => $data_contactos_admin,
            'data_contactos_coords' => $data_contactos_coords,
            'data_header'  => $data_header,
            'data_footer'  => $data_footer
        ]);
    }
}
