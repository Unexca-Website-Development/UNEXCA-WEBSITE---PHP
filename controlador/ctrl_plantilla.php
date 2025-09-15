<?php
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaServicio.php');

//Esta linea para testear el footer
require_once colocar_ruta_sistema('@modelo/plantilla/obtener_links_footer.php');

$servicio = new PlantillaServicio();

$data_header = $servicio->obtenerDatosHeader();
$data_footer = obtener_links_footer();