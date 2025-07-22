<?php
$rutas = require_once __DIR__ . '/alias_rutas.php';
require_once __DIR__ . '/funciones.php';

// Definición de páginas permitidas
$paginasPermitidas = [
    'inicio' => 'inicio.php',
];

$pagina = $_GET['pagina'] ?? 'inicio';

if (!array_key_exists($pagina, $paginasPermitidas)) {
    http_response_code(404);
    die("Página no encontrada");
}

// Obtiene la ruta absoluta de la vista correspondiente
$archivoVista = colocar_ruta_sistema("@paginas/{$paginasPermitidas[$pagina]}");

// Verifica que el archivo exista físicamente
if (!file_exists($archivoVista)) {
    http_response_code(404);
    die("Archivo de página no encontrado");
}

// Incluye la plantilla base, que usará $archivoVista para cargar el contenido
include colocar_ruta_sistema("@plantilla/plantilla.php");