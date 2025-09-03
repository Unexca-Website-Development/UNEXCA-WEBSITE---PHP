<?php

require_once colocar_ruta_sistema('@servicios/paginas/CarrerasServicio.php');

$servicio = new CarrerasServicio();
$resultado = $servicio->obtenerDatosCarrera('ing-informatica');

echo '<pre>';
print_r($resultado);
echo '</pre>';


renderizar_detalle_carrera($resultado);