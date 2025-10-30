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

        //Esta linea de codigo puede dar error en linux si no tiene los permisos para modificar carpetas
        //En ese caso, corregir los permisos o comentar esta linea
        file_put_contents(self::obtenerRutaLog(), $entrada, FILE_APPEND | LOCK_EX);
    }
}
