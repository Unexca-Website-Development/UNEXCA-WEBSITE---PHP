<?php
require_once dirname(__DIR__) . '/servicios/utilidades.php';
require_once dirname(__DIR__) . '/servicios/alias_rutas.php';
require_once dirname(__DIR__) . '/servicios/paginas_permitidas.php';
require_once colocar_ruta_sistema('@servicios/carga_componentes.php');

require_once colocar_ruta_sistema('@servicios/nucleo/Logger.php');
require_once colocar_ruta_sistema('@servicios/nucleo/ManejadorErrores.php');
require_once colocar_ruta_sistema('@servicios/nucleo/Router.php');
require_once colocar_ruta_sistema('@servicios/nucleo/ControladorErroresHTTP.php');

use Servicios\Nucleo\Logger;
use Servicios\Nucleo\ManejadorErrores;
use Servicios\Nucleo\Router;
use Servicios\Nucleo\ControladorErroresHTTP;

// Registrar manejador global de errores
ManejadorErrores::registrarManejadores();

if (isset($_GET['ruta'])) {
    Router::dispatch();
    exit;
}

$pagina = $_GET['pagina'] ?? 'inicio';

// Validar que la página esté permitida
if (!array_key_exists($pagina, $paginas_permitidas)) {
    http_response_code(404);
    ControladorErroresHTTP::error404();
    exit;
}

// Obtiene la ruta absoluta de la vista correspondiente
$vista_plantilla = colocar_ruta_sistema("@paginas/{$paginas_permitidas[$pagina]}");

// Verifica que el archivo exista físicamente
if (!file_exists($vista_plantilla)) {
    http_response_code(404);
    ControladorErroresHTTP::error404();
    exit;
}

// Cargar controlador de la plantilla
$ctrlPlantilla = colocar_ruta_sistema("@controlador/plantillaControlador.php");
if (file_exists($ctrlPlantilla)) {
    require_once $ctrlPlantilla;
}

// Cargar controlador específico de la página
$rutaControlador = colocar_ruta_sistema("@controlador/{$pagina}Controlador.php");
if (file_exists($rutaControlador)) {
    require_once $rutaControlador;
}

// Cargar la plantilla base
include colocar_ruta_sistema("@plantilla/plantilla.php");
