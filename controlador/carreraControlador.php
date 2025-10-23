<?php
require_once colocar_ruta_sistema('@servicios/paginas/CarrerasServicio.php');

$slug = $_GET['nombre'] ?? null;

if (!$slug) {
    die("Carrera no encontrada");
}

$servicio = new CarrerasServicio();
$data_carreras = $servicio->obtenerDatosCarrera($slug);

$head_data = [
    "title" => $data_carreras['titulo'] . " - UNEXCA",
    "styles" => [
        "@estilos/paginas/carrera.css",
    ],
    "meta" => [
        "description" => $data_carreras['descripcion'],
        "keywords" => "UNEXCA, universidad, carrera, " . strtolower($data_carreras['titulo']),
    ],
];
