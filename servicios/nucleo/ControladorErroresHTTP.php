<?php

namespace Servicios\Nucleo;

use Servicios\Nucleo\Logger;

class ControladorErroresHTTP {

    public static function error404() {
        http_response_code(404);
        Logger::registrar('HTTP 404', 'Recurso no encontrado', $_SERVER['REQUEST_URI'], null);
        include colocar_ruta_sistema('@vista/errores/404.php');
        exit;
    }

    public static function error403() {
        http_response_code(403);
        Logger::registrar('HTTP 403', 'Acceso no autorizado', $_SERVER['REQUEST_URI'], null);
        include colocar_ruta_sistema('@vista/errores/403.php');
        exit;
    }

    public static function error500() {
        http_response_code(500);
        Logger::registrar('HTTP 500', 'Error interno del servidor', $_SERVER['REQUEST_URI'], null);
        include colocar_ruta_sistema('@vista/errores/500.php');
        exit;
    }
}
