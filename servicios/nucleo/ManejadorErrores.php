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
        return true;
    }

    public static function manejarExcepcion($excepcion) {
        Logger::registrar('EXCEPCION', $excepcion->getMessage(), $excepcion->getFile(), $excepcion->getLine());
        self::mostrarError500($excepcion);
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

    // Nueva versión: acepta una excepción opcional
    private static function mostrarError500($excepcion = null) {
        $app_env = isset($_ENV['APP_ENV']) ? $_ENV['APP_ENV'] : 'desarrollo';
        if ($app_env === 'produccion') {
            http_response_code(500);
            include colocar_ruta_sistema('@vista/errores/500.php');
        } else {
            echo '<h3>Ha ocurrido un error en la aplicación (modo desarrollo).</h3>';
            echo '<pre>';
            if ($excepcion) {
                echo 'Excepción: ' . $excepcion->getMessage() . "\n";
                echo $excepcion->getFile() . ':' . $excepcion->getLine() . "\n";
                echo $excepcion->getTraceAsString();
            } else {
                $error = error_get_last();
                if ($error) {
                    print_r($error);
                } else {
                    echo 'Sin información adicional disponible.';
                }
            }
            echo '</pre>';
        }
    }
}
