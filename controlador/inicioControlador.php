<?php
/**
 * Controlador de la página de inicio.
 *
 * Este archivo obtiene los datos necesarios para mostrar las carreras en la página principal
 * y configura los metadatos y estilos para el <head> de la vista.
 */
require_once colocar_ruta_sistema('@servicios/paginas/InicioServicio.php');

$servicio = new \Servicios\Paginas\InicioServicio();

$data_carrera = $servicio->obtenerDatosCarreras();

$head_data = [
    "title" => "Inicio - UNEXCA",
    "styles" => [
        "@estilos/paginas/inicio.css",
        "@estilos/componentes/botones.css"
    ],
    "meta" => [
        "description" => "Página de inicio de la UNEXCA.",
        "keywords" => "UNEXCA, universidad, inicio",
    ]
];
