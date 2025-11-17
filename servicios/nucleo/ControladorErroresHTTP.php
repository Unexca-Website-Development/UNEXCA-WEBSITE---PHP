<?php

namespace Servicios\Nucleo;

use Servicios\Nucleo\Logger;

/**
 * Controlador de errores HTTP.
 *
 * Proporciona métodos estáticos para manejar errores HTTP comunes (404, 403, 500),
 * registrando la incidencia en los logs y mostrando la vista correspondiente.
 */
class ControladorErroresHTTP {

    /**
     * Maneja un error 404 (Recurso no encontrado).
     * Registra el evento y carga la vista de error 404.
     */
    public static function error404() {
        http_response_code(404);
        Logger::registrar('HTTP 404', 'Recurso no encontrado', $_SERVER['REQUEST_URI'], null);
        include colocar_ruta_sistema('@vista/errores/404.php');
        exit;
    }

    /**
     * Maneja un error 403 (Acceso no autorizado).
     * Registra el evento y carga la vista de error 403.
     */
    public static function error403() {
        http_response_code(403);
        Logger::registrar('HTTP 403', 'Acceso no autorizado', $_SERVER['REQUEST_URI'], null);
        include colocar_ruta_sistema('@vista/errores/403.php');
        exit;
    }

    /**
     * Maneja un error 500 (Error interno del servidor).
     * Registra el evento y carga la vista de error 500.
     */
    public static function error500() {
        http_response_code(500);
        Logger::registrar('HTTP 500', 'Error interno del servidor', $_SERVER['REQUEST_URI'], null);
        include colocar_ruta_sistema('@vista/errores/500.php');
        exit;
    }
}