<?php
require_once colocar_ruta_sistema('@modelo/plantilla/obtener_links_header.php');
require_once colocar_ruta_sistema('@modelo/plantilla/obtener_links_footer.php');

require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaServicio.php');

$servicio = new PlantillaServicio();

$data_header = $servicio->obtenerDatosHeader();
$data_footer = $servicio->obtenerDatosFooter();

// $data_header = obtener_links_header();
// $data_footer = obtener_links_footer();