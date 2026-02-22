<?php
use Servicios\Nucleo\ControladorErroresHTTP;

require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaAdminServicio.php');

class AdminControlador extends BaseControlador {

    private $servicio_admin;

    public function __construct() {
        $this->servicio_admin = new \Servicios\Plantilla\PlantillaAdminServicio();
    }

    public function index(array $seccion): void {
        $url = $seccion['seccion'] ?? $seccion['seccion']['inicio'];

        if (empty($url) || strlen($url) > 100) {
            ControladorErroresHTTP::error404();
            return;
        }

        $url = normalizar_texto($url, '-');

        if (strpos($url, '--') !== false) {
            ControladorErroresHTTP::error404();
            return;
        }

        $data_menu_control = $this->servicio_admin->obtenerMenuControl($url);

        if (!$data_menu_control) {
            ControladorErroresHTTP::error404();
            return;
        }

        $ruta_vista = colocar_ruta_sistema("@vista/paginas/admin/{$url}.php");

        if (!file_exists($ruta_vista)) {
            ControladorErroresHTTP::error404();
            return;
        }

        $this->establecerHead([
            "title" => "Administración de {$seccion['seccion']} - UNEXCA",
            "styles" => [
                "@estilos/paginas/general.css",
                "@estilos/paginas/editorNoticias.css",
                "@estilos/paginas/admin/autoridades.css",
                "@estilos/componentes/menu_control.css",
                "@estilos/paginas/admin/nucleos.css"
                
            ],
            "meta" => [
                "description" => "Panel de control administrativo de la UNEXCA",
                "robots" => "noindex, nofollow"
            ]
        ]);

        $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/admin/admin.php'));
        $this->establecerVista($ruta_vista);

        $datos_para_vista = ['data_menu_control' => $data_menu_control];

        // Cargar datos específicos según la sección
        if ($url === 'autoridades') {
            require_once colocar_ruta_sistema('@servicios/paginas/admin/AdminAutoridadesServicio.php');
            $servicio = new \Servicios\Paginas\Admin\AdminAutoridadesServicio();
            $datos_para_vista['autoridades'] = $servicio->obtenerListado();
        }
        
        if ($url === 'nucleos') {
            require_once colocar_ruta_sistema('@servicios/paginas/admin/AdminNucleosServicio.php');
            $servicio = new \Servicios\Paginas\Admin\AdminNucleosServicio();
            $datos_para_vista['nucleos'] = $servicio->obtenerTodos();
        }

        $this->renderizar($datos_para_vista);
    }
}