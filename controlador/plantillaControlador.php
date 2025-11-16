<?php
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaServicio.php');

/**
 * Controlador base para cargar los datos de la plantilla.
 *
 * Este archivo se incluye en los controladores de páginas para obtener
 * los datos del menú de Header y Footer.
 */

// Instancia del servicio de plantilla
$servicio = new \Servicios\Plantilla\PlantillaServicio();

// Obtener los datos del menú para la cabecera y pie de página
$data_header = $servicio->obtenerDatosMenu('Header');
$data_footer = $servicio->obtenerDatosMenu('Footer');