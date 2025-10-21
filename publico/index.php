<?php
require_once dirname(__DIR__) . '/servicios/utilidades.php';
require_once dirname(__DIR__) . '/servicios/alias_rutas.php';
require_once dirname(__DIR__) . '/servicios/paginas_permitidas.php';

require_once colocar_ruta_sistema('@servicios/carga_componentes.php');

$pagina = $_GET['pagina'] ?? 'inicio';

// Validar que la página esté permitida
if (!array_key_exists($pagina, $paginas_permitidas)) {
    http_response_code(404);
    die("Página no permitida");
}

// Obtiene la ruta absoluta de la vista correspondiente
$vista_plantilla = colocar_ruta_sistema("@paginas/{$paginas_permitidas[$pagina]}");

// Verifica que el archivo exista físicamente
if (!file_exists($vista_plantilla)) {
    http_response_code(404);
    die("Archivo de vista no encontrado");
}

// Cargar controlador de la plantilla
$ctrlPlantilla = colocar_ruta_sistema("@controlador/ctrl_plantilla.php");
if (file_exists($ctrlPlantilla)) {
    require_once $ctrlPlantilla;
}

// Cargar controlador específico de la página
$rutaControlador = colocar_ruta_sistema("@controlador/ctrl_{$pagina}.php");
if (file_exists($rutaControlador)) {
    require_once $rutaControlador;
}

// Cargar la plantilla base
include colocar_ruta_sistema("@plantilla/noticias_editor.php");
