<?php
require_once colocar_ruta_sistema('@servicios/paginas/InicioServicio.php');
require_once colocar_ruta_sistema('@modelo/paginas/obtener_noticias.php');


$servicio = new \Servicios\Paginas\InicioServicio();

$data_carrera = $servicio->obtenerDatosCarreras();
$data_noticias = $servicio->obtenerDatosNoticiasSimples();;

$head_data = [
    "title" => "Inicio - UNEXCA",

    "styles" => 
    [
        "@estilos/paginas/inicio.css",
        "@estilos/componentes/botones.css"
    ],

    "meta" => 
    [
        "description" => "Página de inicio de la UNEXCA.",
        "keywords" => "UNEXCA, universidad, inicio",
    ]
];
