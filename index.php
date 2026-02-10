<?php
/**
 * index.php
 *
 * Punto de entrada principal del proyecto.
 * Todas las peticiones al sitio pasan por este archivo, que inicializa el entorno, carga utilidades y enruta la petición.
 *
 * Flujo de ejecución:
 * 1. Carga variables de entorno desde el archivo `.env`.
 * 2. Carga utilidades y alias de rutas.
 * 3. Carga componentes del sistema (plantillas, vistas parciales, funciones helper).
 * 4. Inicializa servicios del núcleo: Logger, manejador de errores, router y controlador de errores HTTP.
 * 5. Registra el manejador global de errores.
 * 6. Enruta la petición actual usando la clase Router.
 * 7. Finaliza la ejecución.
 *
 * Dependencias:
 * - @servicios/cargar_env.php: carga variables de entorno.
 * - @servicios/utilidades.php: funciones helper generales.
 * - @servicios/alias_rutas.php: definición de alias de rutas.
 * - @servicios/carga_componentes.php: carga de componentes reutilizables.
 * - @servicios/nucleo/Logger.php: logging de eventos y errores.
 * - @servicios/nucleo/ManejadorErrores.php: manejo centralizado de errores y excepciones.
 * - @servicios/nucleo/Router.php: ruteo de URLs y llamadas a controladores.
 * - @servicios/nucleo/ControladorErroresHTTP.php: manejo de errores HTTP.
 *
 * Nota:
 * - No debe incluir lógica de negocio.
 * - Todas las rutas se resuelven mediante el Router.
 * - El script finaliza con `exit` tras enrutar para evitar ejecución accidental de código posterior.
 */

require_once 'servicios/cargar_env.php';
cargar_env('.env');

define('URL_BASE', $_ENV['URL_BASE'] ?? '');

require_once 'servicios/utilidades.php';
require_once 'servicios/alias_rutas.php';
require_once colocar_ruta_sistema('@servicios/carga_componentes.php');
require_once colocar_ruta_sistema('@servicios/nucleo/Logger.php');
require_once colocar_ruta_sistema('@servicios/nucleo/ManejadorErrores.php');
require_once colocar_ruta_sistema('@servicios/nucleo/Router.php');
require_once colocar_ruta_sistema('@servicios/nucleo/ControladorErroresHTTP.php');
require_once colocar_ruta_sistema('@servicios/nucleo/Renderizador.php');

use Servicios\Nucleo\ManejadorErrores;
use Servicios\Nucleo\Router;

// Registrar manejador global de errores
ManejadorErrores::registrarManejadores();

// Todas las peticiones pasan por el router
Router::enrutar();
exit;