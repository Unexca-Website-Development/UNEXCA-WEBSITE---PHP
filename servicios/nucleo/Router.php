<?php

namespace Servicios\Nucleo;

use Servicios\Nucleo\ControladorErroresHTTP;

class Router {

    public static function dispatch() {
        $ruta = $_GET['ruta'] ?? '';
        $ruta = trim($ruta, '/');
        $segmentos = explode('/', $ruta);

        $controlador = !empty($segmentos[0]) ? strtolower($segmentos[0]) : 'inicio';
        $slug = $segmentos[1] ?? null;

        $archivoControlador = colocar_ruta_sistema("@controlador/{$controlador}Controlador.php");
        $vista_plantilla = colocar_ruta_sistema("@paginas/{$controlador}.php");
        $ctrlPlantilla = colocar_ruta_sistema("@controlador/plantillaControlador.php");

        if (file_exists($archivoControlador)) {
            $_GET['nombre'] = $slug;
            if (file_exists($ctrlPlantilla)) {
                require_once $ctrlPlantilla;
            }
            require_once $archivoControlador;
            if (file_exists($vista_plantilla)) {
                include colocar_ruta_sistema("@plantilla/plantilla.php");
            } else {
                ControladorErroresHTTP::error404();
            }
        } else {
            ControladorErroresHTTP::error404();
        }
        exit;
    }
}
