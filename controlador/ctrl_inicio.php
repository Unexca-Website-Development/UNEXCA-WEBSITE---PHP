<?php
require_once colocar_ruta_sistema('@modelo/paginas/obtener_carreras.php');
require_once colocar_ruta_sistema('@modelo/paginas/obtener_noticias.php');

$data_carrera = obtener_carreras();
$data_noticias = obtener_noticias();