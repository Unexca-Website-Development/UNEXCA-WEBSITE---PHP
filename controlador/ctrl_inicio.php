<?php
require_once colocar_ruta_sistema('@modelo/paginas/obtener_carreras.php');
require_once colocar_ruta_sistema('@modelo/paginas/obtener_noticias.php');

$data_ejemplo_carrera = obtener_carreras();
$data_ejemplo_noticias = obtener_noticias();