<?php
require_once colocar_ruta_sistema('@servicios/paginas/CarrerasServicio.php');

$servicio = new CarrerasServicio();

$data_carreras = $servicio->obtenerDatosCarrera($slug);