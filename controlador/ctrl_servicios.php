<?php
require_once colocar_ruta_sistema('@servicios/paginas/ServiciosServicio.php');

$servicio = new ServiciosServicio();

$data_servicios = $servicio->obtenerDatosServicios();

$head_data = [
	"title" => "Servicios - UNEXCA",

	"styles" => 
	[
		"@estilos/componentes/desplegable.css"
	],

	"meta" => 
	[
		"description" => "Página de servicios ofrecidos por la UNEXCA.",
		"keywords" => "UNEXCA, servicios, educación, universidad, asesoría",
	]
];