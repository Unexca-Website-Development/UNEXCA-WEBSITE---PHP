<?php
namespace Servicios\Nucleo;

/**
 * Clase ManejadorErrores
 *
 * Gestiona la captura y registro de errores, excepciones y errores fatales.
 * 
 * Funciones principales:
 * - Registrar manejadores globales para errores, excepciones y apagado de PHP.
 * - Clasificar los tipos de error (ERROR, ADVERTENCIA, AVISO, DESCONOCIDO).
 * - Registrar los errores usando Logger.
 * - Mostrar una página de error 500 en producción o detalle en desarrollo.
 */
class ManejadorErrores {

    /**
     * Registra los manejadores personalizados para errores, excepciones y apagado.
     *
     * @return void
     */
    public static function registrarManejadores() {
        set_error_handler([self::class, 'manejarError']);
        set_exception_handler([self::class, 'manejarExcepcion']);
        register_shutdown_function([self::class, 'manejarApagado']);
    }

    /**
     * Maneja errores tradicionales de PHP.
     *
     * @param int $numeroError Número de error de PHP.
     * @param string $mensaje Mensaje de error.
     * @param string $archivo Archivo donde ocurrió el error.
     * @param int $linea Línea del error.
     * @return bool Siempre retorna true para indicar que el error fue manejado.
     */
    public static function manejarError($numeroError, $mensaje, $archivo, $linea) {
        $tipo = self::tipoError($numeroError);
        Logger::registrar($tipo, $mensaje, $archivo, $linea);

        if (self::esErrorFatal($numeroError)) {
            self::mostrarError500();
            exit;
        }
        return true;
    }

    /**
     * Maneja excepciones no capturadas.
     *
     * @param \Throwable $excepcion La excepción no capturada.
     * @return void
     */
    public static function manejarExcepcion($excepcion) {
        Logger::registrar('EXCEPCION', $excepcion->getMessage(), $excepcion->getFile(), $excepcion->getLine());
        self::mostrarError500($excepcion);
        exit;
    }

    /**
     * Maneja el apagado de PHP y captura errores fatales que ocurrieron antes del shutdown.
     *
     * @return void
     */
    public static function manejarApagado() {
        $error = error_get_last();
        if ($error && self::esErrorFatal($error['type'])) {
            Logger::registrar('FATAL', $error['message'], $error['file'], $error['line']);
            self::mostrarError500();
        }
    }

    /**
     * Devuelve la descripción textual del tipo de error de PHP.
     *
     * @param int $numeroError Número de error de PHP.
     * @return string Tipo de error.
     */
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

    /**
     * Determina si un número de error corresponde a un error fatal.
     *
     * @param int $numeroError
     * @return bool
     */
    private static function esErrorFatal($numeroError) {
        return in_array($numeroError, [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE]);
    }

    /**
     * Muestra la página de error 500.
     *
     * @param \Throwable|null $excepcion Excepción opcional para mostrar detalles en desarrollo.
     * @return void
     */
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
