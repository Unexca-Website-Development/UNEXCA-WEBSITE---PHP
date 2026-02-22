<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaAdminServicio.php');


class AdminNoticiasControlador extends BaseControlador {

    private $servicio_admin;

    public function __construct() {
        $this->servicio_admin = new \Servicios\Plantilla\PlantillaAdminServicio();
    }


    public function index(): void 
    {
        $data_menu_control = $this->servicio_admin->obtenerMenuControl();

        $this->establecerHead([
            "title" => "Editor de Noticias - UNEXCA",
            "styles" => ["@estilos/paginas/editorNoticias.css"],
            "meta" => [
                "description" => "Editor de Noticias.",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/admin/noticias.php'));
        $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/admin/admin.php'));
        $this->renderizar([
            'data_menu_control' => $data_menu_control
        ]);
    }

    public function GuardarNoticia(array $params): void
    {
        header('Content-Type: application/json');
        echo json_encode(['recibido' => $params]);
    }
}
