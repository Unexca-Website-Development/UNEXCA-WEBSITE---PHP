<?php
/**
 * Controlador de la página de Carrera.
 *
 * Este archivo valida y normaliza el parámetro 'nombre' recibido por GET,
 * obtiene los datos completos de la carrera mediante el servicio correspondiente,
 * y prepara la información para el <head> de la vista.
 */
require_once colocar_ruta_sistema('@servicios/paginas/CarrerasServicio.php');

$slug = $_GET['nombre'] ?? null;

if (empty($slug) || !is_string($slug) || strlen($slug) > 100) {
    http_response_code(400);
    die("Parámetro inválido");
}

$slug_normalizado = normalizar_texto($slug, '-');

if ($slug_normalizado !== normalizar_texto($slug_normalizado, '-') || strpos($slug_normalizado, '--') !== false) {
    http_response_code(400);
    die("Formato de carrera inválido");
}

$slug = $slug_normalizado;

$servicio = new \Servicios\Paginas\CarrerasServicio();
$data_carreras = $servicio->obtenerDatosCarrera($slug);

if (!$data_carreras) {
    http_response_code(404);
    die("Carrera no encontrada");
}

$head_data = [
    "title" => htmlspecialchars(trim($data_carreras['titulo']), ENT_QUOTES, 'UTF-8') . " - UNEXCA",
    "styles" => [
        "@estilos/paginas/carrera.css",
    ],
    "meta" => [
        "description" => htmlspecialchars(trim($data_carreras['descripcion']), ENT_QUOTES, 'UTF-8'),
        "keywords" => "UNEXCA, universidad, carrera, " . htmlspecialchars(trim(strtolower($data_carreras['titulo'])), ENT_QUOTES, 'UTF-8'),
    ],
];