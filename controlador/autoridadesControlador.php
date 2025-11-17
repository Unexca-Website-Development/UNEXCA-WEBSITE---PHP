<?php
/**
 * Controlador de la página de Autoridades Académicas.
 *
 * Este archivo obtiene los datos de las autoridades mediante el servicio correspondiente
 * y prepara la información para el <head> de la vista.
 */
require_once colocar_ruta_sistema('@servicios/paginas/AutoridadesServicio.php');

$servicio = new \Servicios\Paginas\AutoridadesServicio();
$data_autoridades = $servicio->obtenerDatosAutoridades();

$head_data = [
    "title" => "Autoridades Académicas - UNEXCA",
    "styles" => [
        "@estilos/paginas/autoridades.css",
    ],
    "meta" => [
        "description" => "Conoce a las autoridades académicas de la UNEXCA y su rol dentro de la universidad.",
        "keywords" => "UNEXCA, autoridades, universidad, rector, vicerrector, académicos",
    ]
];
