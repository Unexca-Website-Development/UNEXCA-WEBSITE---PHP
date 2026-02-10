<?php
/**
 * Controlador para la sección administrativa.
 */
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaAdminServicio.php');

class AdminControlador extends BaseControlador {

    private $servicio_admin;

    public function __construct() {
        $this->servicio_admin = new \Servicios\Plantilla\PlantillaAdminServicio();
    }

    public function index(): void {
        $data_menu_control = $this->servicio_admin->obtenerMenuControl();

        $this->establecerHead([
            "title" => "Administración - UNEXCA",
            "styles" => [
                "@estilos/paginas/general.css",
                "@estilos/componentes/menu_control.css"
            ],
            "meta" => [
                "description" => "Panel de control administrativo de la UNEXCA",
                "robots" => "noindex, nofollow"
            ]
        ]);

        $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/admin.php'));
        $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/inicio.php'));

        $this->renderizar([
            'data_menu_control' => $data_menu_control
        ]);
    }
}
