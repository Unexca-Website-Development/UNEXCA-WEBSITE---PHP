<?php
use Servicios\Nucleo\ControladorErroresHTTP;

abstract class BaseControlador {

		protected array $head_data = [];
		protected string $vista;

		public function establecerHead(array $datos): void {
				$this->head_data = $datos;
		}

		public function establecerVista(string $ruta): void {
				$this->vista = $ruta;
		}

		protected function renderizar(array $datos_adicionales = []): void {

				$controladorPlantilla = colocar_ruta_sistema('@controlador/plantillaControlador.php');
				if (file_exists($controladorPlantilla)) {
						require_once $controladorPlantilla;
				}

				if (!isset($this->vista) || !file_exists($this->vista)) {
						ControladorErroresHTTP::error500();
						return;
				}

				$head_data = $this->head_data;
				$vista = $this->vista;

				if (!empty($datos_adicionales)) {
						extract($datos_adicionales);
				}

				include colocar_ruta_sistema('@plantilla/plantilla.php');
		}
}
