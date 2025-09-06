<?php
require_once colocar_ruta_sistema('@servicios/paginas/AutoridadesServicio.php');

$servicio = new AutoridadesServicio();

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
