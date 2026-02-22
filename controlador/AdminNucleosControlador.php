<?php
/**
 * Controlador para la gestión de Núcleos en el panel de administración.
 */
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/admin/AdminNucleosServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaAdminServicio.php');

class AdminNucleosControlador extends BaseControlador {
        private $servicio;
        private $servicio_admin;

        public function __construct() {
            $this->servicio = new \Servicios\Paginas\Admin\AdminNucleosServicio();
            $this->servicio_admin = new \Servicios\Plantilla\PlantillaAdminServicio();
        }

    public function index(): void {
        $data_menu_control = $this->servicio_admin->obtenerMenuControl();
        $nucleos = $this->servicio->obtenerTodos();

        $this->establecerHead([
            "title" => "Gestión de Núcleos - UNEXCA",
            "styles" => [
                "@estilos/paginas/admin/nucleos.css"
                ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/admin/nucleos.php'));
        $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/admin/admin.php'));
        $this->renderizar([
            'data_menu_control' => $data_menu_control,
            'nucleos' => $nucleos
        ]);
    }

    public function procesarAccion(): void {

        $accion = $_POST['accion'] ?? '';
        $id = $_POST['id'] ?? null;

        switch ($accion) {
            case 'guardar':
                $datos = [
                    'nombre' => $_POST['nombre'],
                    'direccion' => $_POST['direccion']
                ];
                $imagen = $_FILES['imagen'] ?? null;

                if ($id) {
                    $this->servicio->actualizar($id, $datos, $imagen);
                } else {
                    $this->servicio->guardar($datos, $imagen);
                }
                break;

            case 'eliminar':
                if ($id) {
                    $this->servicio->eliminar($id);
                }
                break;
        }
        
        header('Location: ' . colocar_enlace('admin-nucleos'));
        exit;
    }
}
