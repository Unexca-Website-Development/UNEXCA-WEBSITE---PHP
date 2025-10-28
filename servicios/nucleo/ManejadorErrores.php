<?php

namespace Servicios\Nucleo;

class ManejadorErrores {

    public static function registrarManejadores() {
        set_error_handler([self::class, 'manejarError']);
        set_exception_handler([self::class, 'manejarExcepcion']);
        register_shutdown_function([self::class, 'manejarApagado']);
    }

    public static function manejarError($numeroError, $mensaje, $archivo, $linea) {
        $tipo = self::tipoError($numeroError);
        Logger::registrar($tipo, $mensaje, $archivo, $linea);

        if (self::esErrorFatal($numeroError)) {
            self::mostrarError500();
            exit;
        }
        return true; // evita que PHP continúe con su manejo normal
    }

    public static function manejarExcepcion($excepcion) {
        Logger::registrar('EXCEPCION', $excepcion->getMessage(), $excepcion->getFile(), $excepcion->getLine());
        self::mostrarError500();
        exit;
    }

    public static function manejarApagado() {
        $error = error_get_last();
        if ($error && self::esErrorFatal($error['type'])) {
            Logger::registrar('FATAL', $error['message'], $error['file'], $error['line']);
            self::mostrarError500();
        }
    }

    private static function tipoError($numeroError) {
        switch ($numeroError) {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                return 'ERROR';
            case E_WARNING:
            case E_USER_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
                return 'ADVERTENCIA';
            case E_NOTICE:
            case E_USER_NOTICE:
                return 'AVISO';
            default:
                return 'DESCONOCIDO';
        }
    }

    private static function esErrorFatal($numeroError) {
        return in_array($numeroError, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]);
    }

    private static function mostrarError500() {
        if (getenv('APP_ENV') === 'production') {
            http_response_code(500);
            include colocar_ruta_sistema('@vista/errors/500.php');
        } else {
            echo '<pre>';
            print_r(error_get_last());
            echo '</pre>';
        }
    }
}
