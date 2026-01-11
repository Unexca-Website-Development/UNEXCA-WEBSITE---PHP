<?php

namespace Servicios\Nucleo;

use Servicios\Nucleo\ControladorErroresHTTP;

class Router {

    public static function enrutar(): void {
        $metodoHttp = $_SERVER['REQUEST_METHOD'];
        $pagina = $_GET['pagina'] ?? 'inicio';
        $rutas = require colocar_ruta_sistema('@servicios/rutas.php');

        $rutaEncontrada = self::buscarRuta($rutas, $pagina, $metodoHttp);

        if (!$rutaEncontrada) {
            ControladorErroresHTTP::error404();
            return;
        }

        [$controladorNombre, $metodoNombre] = explode('@', $rutaEncontrada[2]);

        $controlador = self::cargarControlador($controladorNombre);

        self::ejecutarMetodo($controlador, $metodoNombre);
    }

    private static function buscarRuta(array $rutas, string $pagina, string $metodoHttp): ?array {
        foreach ($rutas as $ruta) {
            [$metodo, $rutaNombre, $destino] = $ruta;
            if ($metodo === $metodoHttp && $rutaNombre === $pagina) {
                return $ruta;
            }
        }
        return null;
    }

    private static function cargarControlador(string $nombre): object {
        $archivo = colocar_ruta_sistema("@controlador/{$nombre}.php");

        if (!file_exists($archivo)) {
            ControladorErroresHTTP::error404();
        }

        require_once $archivo;

        if (!class_exists($nombre)) {
            ControladorErroresHTTP::error404();
        }

        return new $nombre();
    }

    private static function ejecutarMetodo(object $controlador, string $metodo): void {
        if (!method_exists($controlador, $metodo)) {
            ControladorErroresHTTP::error404();
        }

        $parametros = $_GET;
        unset($parametros['pagina']);

        call_user_func_array([$controlador, $metodo], $parametros);
    }
}
