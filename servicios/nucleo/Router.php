<?php

namespace Servicios\Nucleo;

use Servicios\Nucleo\ControladorErroresHTTP;

class Router {

    public static function enrutar() {
        $ruta = $_GET['ruta'] ?? '';
        $ruta = trim($ruta, '/');
        $segmentos = explode('/', $ruta);

        // Lista blanca de páginas permitidas
        $paginas_permitidas = obtener_paginas_permitidas();

        $slugPagina = !empty($segmentos[0]) ? strtolower($segmentos[0]) : 'inicio';
        $slug = $segmentos[1] ?? null;

        if (!is_array($paginas_permitidas) || !array_key_exists($slugPagina, $paginas_permitidas)) {
            ControladorErroresHTTP::error404();
            exit;
        }

        // Resolver vista desde la lista blanca (permite mapeo guiones -> archivo snake_case)
        $archivoVista = $paginas_permitidas[$slugPagina];
        $vista_plantilla = colocar_ruta_sistema("@paginas/{$archivoVista}");

        // Resolver controlador en múltiples formatos
        $baseSnake = convertir_slug_a_snake($slugPagina);
        $baseCamel = convertir_snake_a_camel($baseSnake);

        $ctrlSnake = colocar_ruta_sistema("@controlador/{$baseSnake}Controlador.php");
        $ctrlCamel = colocar_ruta_sistema("@controlador/{$baseCamel}Controlador.php");
        $ctrlPlantilla = colocar_ruta_sistema("@controlador/plantillaControlador.php");

        // Parámetro adicional accesible para el controlador
        $_GET['nombre'] = $slug;

        if (file_exists($ctrlPlantilla)) {
            require_once $ctrlPlantilla;
        }

        if (file_exists($ctrlSnake)) {
            require_once $ctrlSnake;
        } elseif (file_exists($ctrlCamel)) {
            require_once $ctrlCamel;
        }

        if (file_exists($vista_plantilla)) {
            include colocar_ruta_sistema("@plantilla/plantilla.php");
        } else {
            ControladorErroresHTTP::error404();
        }
        exit;
    }
}
