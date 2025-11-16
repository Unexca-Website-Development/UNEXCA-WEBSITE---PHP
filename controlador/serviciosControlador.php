<?php
require_once colocar_ruta_sistema('@servicios/paginas/ServiciosServicio.php');

/**
 * Controlador de la página de Servicios.
 *
 * Este controlador obtiene los datos de los servicios desde el modelo a través del servicio,
 * y prepara la información del <head> para la vista.
 */

// Instancia del servicio de servicios
$servicio = new \Servicios\Paginas\ServiciosServicio();

// Obtener los datos de los servicios
$data_servicios = $servicio->obtenerDatosServicios();

// Configuración de la información del <head>
$head_data = [
	"title" => "Servicios - UNEXCA",
	"styles" => [
		"@estilos/componentes/desplegable.css"
	],
	"meta" => [
		"description" => "Página de servicios ofrecidos por la UNEXCA.",
		"keywords" => "UNEXCA, servicios, educación, universidad, asesoría",
	]
];
