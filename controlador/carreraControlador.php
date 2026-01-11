<?php
use Servicios\Nucleo\ControladorErroresHTTP;

require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/CarrerasServicio.php');

class CarreraControlador extends BaseControlador {

    public function mostrar($slug = "distribucion-y-logistica"): void {

        if (empty($slug) || !is_string($slug) || strlen($slug) > 100) {
            ControladorErroresHTTP::error404();
            return;
        }

        $slug_normalizado = normalizar_texto($slug, '-');

        if ($slug_normalizado !== normalizar_texto($slug_normalizado, '-') || strpos($slug_normalizado, '--') !== false) {
             ControladorErroresHTTP::error404();
             return;
        }

        $slug = $slug_normalizado;

        $servicio = new \Servicios\Paginas\CarrerasServicio();
        $data_carreras = $servicio->obtenerDatosCarrera($slug);

        if (!$data_carreras) {
             ControladorErroresHTTP::error404();
             return;
        }

        $this->establecerHead([
            "title" => htmlspecialchars(trim($data_carreras['titulo']), ENT_QUOTES, 'UTF-8') . " - UNEXCA",
            "styles" => [
                "@estilos/paginas/carrera.css",
            ],
            "meta" => [
                "description" => htmlspecialchars(trim($data_carreras['descripcion']), ENT_QUOTES, 'UTF-8'),
                "keywords" => "UNEXCA, universidad, carrera, " . htmlspecialchars(trim(strtolower($data_carreras['titulo'])), ENT_QUOTES, 'UTF-8'),
            ],
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/carrera.php'));

        $this->renderizar([
            'data_carreras' => $data_carreras
        ]);
    }
}