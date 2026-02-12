<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/InicioServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');

class InicioControlador extends BaseControlador {

  public function index(): void {

    $servicio = new \Servicios\Paginas\InicioServicio();
    $servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();

    $data_carrera = $servicio->obtenerDatosCarreras();
    $data_header = $servicio_plantilla->obtenerDatosMenu('Header');
    $data_footer = $servicio_plantilla->obtenerDatosMenu('Footer');

    $this->establecerHead([
      "title" => "Inicio - UNEXCA",
      "styles" => [
        "@estilos/paginas/inicio.css",
        "@estilos/componentes/botones.css"
      ],
      "meta" => [
        "description" => "Página de inicio de la UNEXCA.",
        "keywords" => "UNEXCA, universidad, inicio",
      ]
    ]);

    $this->establecerVista(colocar_ruta_sistema('@vista/paginas/inicio.php'));

    $this->renderizar([
      'data_carrera' => $data_carrera,
      'data_header'  => $data_header,
      'data_footer'  => $data_footer
    ]);
  }
}
