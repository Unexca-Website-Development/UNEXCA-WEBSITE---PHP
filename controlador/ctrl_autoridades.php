<?php
require_once colocar_ruta_sistema('@servicios/paginas/AutoridadesServicio.php');

$servicio = new AutoridadesServicio();

$data_autoridades = $servicio->obtenerDatosAutoridades();