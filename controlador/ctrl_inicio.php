<?php
require_once colocar_ruta_sistema('@servicios/paginas/InicioServicio.php');

require_once colocar_ruta_sistema('@modelo/paginas/obtener_noticias.php');

$servicio = new InicioServicio();

$data_carrera = $servicio->obtenerDatosCarreras();
$data_noticias = obtener_noticias();