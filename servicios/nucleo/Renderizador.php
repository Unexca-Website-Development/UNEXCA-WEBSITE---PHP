<?php
namespace Servicios\Nucleo;

use Servicios\Nucleo\ControladorErroresHTTP;

class Renderizador {

		public function render(
				array $vistas,
				array $head = [],
				array $datos = []
		): void {

				$plantilla = $vistas['plantilla'] ?? null;
				$vista  = $vistas['vista'] ?? null;

				if ($plantilla !== null && !file_exists($plantilla)) {
						ControladorErroresHTTP::error500();
						return;
				}

				if ($vista === null || !file_exists($vista)) {
						ControladorErroresHTTP::error500();
						return;
				}

				$head_data = $head;

				extract($datos, EXTR_SKIP);

				if ($plantilla !== null) {
						include $plantilla;
				} else {
						include $vista;
				}
		}
}
