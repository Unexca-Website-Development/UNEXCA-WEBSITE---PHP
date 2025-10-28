<?php
require_once colocar_ruta_sistema('@servicios/paginas/ContactosServicio.php');

$servicio = new \Servicios\Paginas\ContactosServicio();

$data_contactos_admin = $servicio->obtenerContactosDirectivos();
$data_contactos_coords = $servicio->obtenerContactosCoordinadores();

$head_data = [
    "title" => "Contactos - UNEXCA",
    "styles" => [
        "@estilos/paginas/contactos.css",
    ],
    "meta" => [
        "description" => "",
        "keywords" => "UNEXCA, universidad, contactos"
    ],
];
