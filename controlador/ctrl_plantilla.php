<?php
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaServicio.php');

$servicio = new PlantillaServicio();

$data_header = $servicio->obtenerDatosMenu('Header');
$data_footer = $servicio->obtenerDatosMenu('Footer');