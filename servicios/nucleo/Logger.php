<?php

namespace Servicios\Nucleo;

/**
 * Clase Logger para registrar eventos y errores de la aplicación en archivos de log.
 *
 * Logs se almacenan en la carpeta definida por colocar_ruta_sistema('@logs')
 * y se crean archivos diarios con nombre "aplicacion-YYYY-MM-DD.log".
 *
 * Métodos:
 *  - registrar(string $tipo, string $mensaje, ?string $archivo = null, ?int $linea = null)
 *      Registra un mensaje de log indicando tipo, mensaje, archivo y línea opcional.
 * 
 * Nota: La escritura de archivos requiere permisos adecuados en la carpeta de logs.
 */
class Logger {
    private static function obtenerRutaLog() {
        $fecha = date('Y-m-d');
        return colocar_ruta_sistema('@logs') . '/aplicacion-' . $fecha . '.log';
    }

    public static function registrar($tipo, $mensaje, $archivo = null, $linea = null) {
        $fechaHora = date('Y-m-d H:i:s');
        $detalles = $archivo ? " ($archivo" . ($linea ? ":$linea" : "") . ")" : "";
        $entrada = "[$fechaHora] $tipo: $mensaje$detalles" . PHP_EOL;

        file_put_contents(self::obtenerRutaLog(), $entrada, FILE_APPEND | LOCK_EX);
    }
}
