<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/ContactosServicio.php');

class ContactosControlador extends BaseControlador {

    public function index(): void {
        $servicio = new \Servicios\Paginas\ContactosServicio();
        $data_contactos_admin = $servicio->obtenerContactosDirectivos();
        $data_contactos_coords = $servicio->obtenerContactosCoordinadores();

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
            'data_contactos_coords' => $data_contactos_coords
        ]);
    }
}
