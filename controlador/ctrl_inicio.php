<?php
require_once colocar_ruta_sistema('@servicios/paginas/InicioServicio.php');
require_once colocar_ruta_sistema('@modelo/paginas/obtener_noticias.php');

$head_data = 
[
    "title" => "Inicio - UNEXCA",
    "styles" => [
        "@estilos/paginas/inicio.css"
    ]
];

$servicio = new InicioServicio();

$data_carrera = $servicio->obtenerDatosCarreras();
$data_noticias = obtener_noticias();