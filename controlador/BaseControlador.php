<?php

use Servicios\Nucleo\Renderizador;
use Servicios\Nucleo\ControladorErroresHTTP;

abstract class BaseControlador {

		protected array $head_data = [];
		protected string $vista;
		protected ?string $plantilla = null;

		public function establecerHead(array $datos): void {
				$this->head_data = $datos;
		}

		public function establecerVista(string $ruta): void {
				$this->vista = $ruta;
		}

		public function establecerPlantilla(string $ruta): void {
				$this->plantilla = $ruta;
		}

		protected function renderizar(array $datos_servicio = []): void {

				if (!isset($this->vista) || !file_exists($this->vista)) {
						ControladorErroresHTTP::error500();
						return;
				}

				$render = new Renderizador();

				$vistas = [
						'plantilla' => $this->plantilla ?? colocar_ruta_sistema('@vista/plantilla/default.php'),
						'vista'  => $this->vista
				];

				$render->render(
						$vistas,
						$this->head_data,
						$datos_servicio
				);
		}
}
