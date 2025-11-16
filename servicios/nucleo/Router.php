<?php
namespace Servicios\Nucleo;

use Servicios\Nucleo\ControladorErroresHTTP;

/**
 * Clase Router
 *
 * Gestiona el enrutamiento de solicitudes HTTP en la aplicación.
 * 
 * - Determina la página solicitada a partir de $_GET['ruta'].
 * - Verifica la lista blanca de páginas permitidas.
 * - Resuelve las rutas de controlador y vista correspondientes.
 * - Redirige a la plantilla principal y carga los controladores.
 * - Maneja errores 404 si la página no existe o no está permitida.
 */
class Router {

    /**
     * Enruta la solicitud HTTP actual.
     *
     * Obtiene la ruta desde la URL, valida contra la lista blanca de páginas,
     * carga el controlador correspondiente y la vista dentro de la plantilla.
     *
     * @return void No retorna; incluye archivos y termina la ejecución.
     */
    public static function enrutar() {
        $ruta = $_GET['ruta'] ?? '';
        $ruta = trim($ruta, '/');
        $segmentos = explode('/', $ruta);

        $paginas_permitidas = obtener_paginas_permitidas();

        $slugPagina = !empty($segmentos[0]) ? strtolower($segmentos[0]) : 'inicio';
        $slug = $segmentos[1] ?? null;

        if (!is_array($paginas_permitidas) || !array_key_exists($slugPagina, $paginas_permitidas)) {
            ControladorErroresHTTP::error404();
            exit;
        }

        $archivoVista = $paginas_permitidas[$slugPagina];
        $vista_plantilla = colocar_ruta_sistema("@paginas/{$archivoVista}");

        $baseSnake = convertir_slug_a_snake($slugPagina);
        $baseCamel = convertir_snake_a_camel($baseSnake);

        $ctrlSnake = colocar_ruta_sistema("@controlador/{$baseSnake}Controlador.php");
        $ctrlCamel = colocar_ruta_sistema("@controlador/{$baseCamel}Controlador.php");
        $ctrlPlantilla = colocar_ruta_sistema("@controlador/plantillaControlador.php");

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