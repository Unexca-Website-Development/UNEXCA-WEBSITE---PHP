<?php
require_once colocar_ruta_sistema('@servicios/paginas/ServiciosServicio.php');

$servicio = new ServiciosServicio();

$data_servicios = $servicio->obtenerDatosServicios();