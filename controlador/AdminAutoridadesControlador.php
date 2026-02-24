<?php
/**
 * Controlador para la gestión de Autoridades Académicas.
 */
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaAdminServicio.php');
require_once colocar_ruta_sistema('@servicios/paginas/admin/AdminAutoridadesServicio.php');
require_once colocar_ruta_sistema('@servicios/nucleo/AuthServicio.php');

class AdminAutoridadesControlador extends BaseControlador {

    private $servicio;
    private $servicio_admin;
    private $authServicio;

    public function __construct() {
        $this->authServicio = new \Servicios\Nucleo\AuthServicio();
        if (!$this->authServicio->estaAutenticado()) {
            header('Location: index.php?pagina=login');
            exit;
        }

        $this->servicio = new \Servicios\Paginas\Admin\AdminAutoridadesServicio();
        $this->servicio_admin = new \Servicios\Plantilla\PlantillaAdminServicio();
    }

    public function index(): void {

        $data_menu_control = $this->servicio_admin->obtenerMenuControl();
        $autoridades = $this->servicio->obtenerListado();

        $this->establecerHead([
            "title" => "Gestión de Autoridades - UNEXCA",
            "styles" => [
                "@estilos/paginas/admin/autoridades.css"
            ]
        ]);

        // Usar el layout administrativo
        $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/admin/admin.php'));
        $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/autoridades.php'));

        $this->renderizar([
            'autoridades' => $autoridades,
            'data_menu_control' => $data_menu_control
            
        ]);
    }

    public function procesarAccion() {
        $accion = $_POST['accion'] ?? '';
        $id = $_POST['id'] ?? null;

        switch ($accion) {
            case 'guardar':
                $datos = [
                    'nombre' => $_POST['nombre'],
                    'cargo' => $_POST['cargo']
                ];
                $imagen = $_FILES['imagen'] ?? null;

                if ($id) {
                    $this->servicio->actualizarAutoridad($id, $datos, $imagen);
                } else {
                    $this->servicio->guardarAutoridad($datos, $imagen);
                }
                break;

            case 'eliminar':
                if ($id) {
                    $this->servicio->eliminarAutoridad($id);
                }
                break;

            case 'subir':
            case 'bajar':
                if ($id) {
                    $this->servicio->reordenar($id, $accion);
                }
                break;
        }
        
        header('Location: ' . colocar_enlace('admin', ['seccion' => 'autoridades']));
        exit;
    }
}
