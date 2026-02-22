<?php
/**
 * Controlador para la gestión de Autoridades Académicas.
 */
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/admin/AdminAutoridadesServicio.php');

class AdminAutoridadesControlador extends BaseControlador {

    private $servicio;

    public function __construct() {
        $this->servicio = new \Servicios\Paginas\Admin\AdminAutoridadesServicio();
    }

    public function index(): void {
        // Manejo de acciones POST (Guardar/Eliminar)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->procesarAccion();
            return;
        }

        // Obtener datos para la vista
        $autoridades = $this->servicio->obtenerListado();

        $this->establecerHead([
            "title" => "Gestión de Autoridades - UNEXCA",
            "styles" => [
                "@estilos/paginas/general.css",
                "@estilos/componentes/menu_control.css",
                "@estilos/paginas/admin/autoridades.css" // Estilo específico (lo crearemos luego)
            ]
        ]);

        // Usar el layout administrativo
        $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/admin.php'));
        $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/autoridades.php'));

        $this->renderizar([
            'autoridades' => $autoridades
        ]);
    }

    private function procesarAccion() {
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
        
        // Redireccionar para evitar reenvío de formulario
        header('Location: ' . colocar_enlace('admin', ['seccion' => 'autoridades']));
        exit;
    }
}
