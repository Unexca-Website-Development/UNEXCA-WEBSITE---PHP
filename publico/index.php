<?php
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

// Todas las peticiones pasan por el router
Router::enrutar();
exit;
