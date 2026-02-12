<?php
/**
 * Controlador de la página de Autoridades Académicas.
 *
 * Este archivo obtiene los datos de las autoridades mediante el servicio correspondiente
 * y prepara la información para el <head> de la vista.
 */
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/AutoridadesServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');


class AutoridadesControlador extends BaseControlador {

	public function index(): void {
		$servicio = new \Servicios\Paginas\AutoridadesServicio();
		$data_autoridades = $servicio->obtenerDatosAutoridades();
		$servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();


		$data_header = $servicio_plantilla->obtenerDatosMenu('Header');
		$data_footer = $servicio_plantilla->obtenerDatosMenu('Footer');

		$this->establecerHead([
			"title" => "Autoridades Académicas - UNEXCA",
			"styles" => ["@estilos/paginas/autoridades.css"],
			"meta" => [
				"description" => "Conoce a las autoridades académicas de la UNEXCA y su rol dentro de la universidad.",
				"keywords" => "UNEXCA, autoridades, universidad, rector, vicerrector, académicos",
			]
		]);

		$this->establecerVista(colocar_ruta_sistema('@paginas/autoridades.php'));

		$this->renderizar([
			'data_autoridades' => $data_autoridades,
			'data_header'  => $data_header,
			'data_footer'  => $data_footer
		]);
	}
}
