<?php

namespace Servicios\Nucleo;

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
