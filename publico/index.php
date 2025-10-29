<?php
require_once dirname(__DIR__) . '/servicios/cargar_env.php';
cargar_env(dirname(__DIR__) . '/.env');

require_once dirname(__DIR__) . '/servicios/utilidades.php';
require_once dirname(__DIR__) . '/servicios/alias_rutas.php';
require_once dirname(__DIR__) . '/servicios/paginas_permitidas.php';
require_once colocar_ruta_sistema('@servicios/carga_componentes.php');
require_once colocar_ruta_sistema('@servicios/nucleo/Logger.php');
require_once colocar_ruta_sistema('@servicios/nucleo/ManejadorErrores.php');
require_once colocar_ruta_sistema('@servicios/nucleo/Router.php');
require_once colocar_ruta_sistema('@servicios/nucleo/ControladorErroresHTTP.php');

use Servicios\Nucleo\ManejadorErrores;
use Servicios\Nucleo\Router;

// Registrar manejador global de errores
ManejadorErrores::registrarManejadores();

// Cargar controlador de plantilla global (header, footer)
$ctrlPlantilla = colocar_ruta_sistema("@controlador/plantillaControlador.php");
if (file_exists($ctrlPlantilla)) {
    require_once $ctrlPlantilla;
}

// Router resuelve ruta y carga controlador + vista específica
Router::enrutar();
exit;
