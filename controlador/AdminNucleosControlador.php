<?php
/**
 * Controlador para la gestión de Núcleos en el panel de administración.
 */
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/admin/AdminNucleosServicio.php');

class AdminNucleosControlador extends BaseControlador {

    private $servicio;

    public function __construct() {
        // A continuación crearé este servicio
        $this->servicio = new \Servicios\Paginas\Admin\AdminNucleosServicio();
    }

    public function index(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->procesarAccion();
            return;
        }

        $nucleos = $this->servicio->obtenerTodos();

        $this->establecerHead([
            "title" => "Gestión de Núcleos - UNEXCA",
            "styles" => [
                "@estilos/paginas/general.css",
                "@estilos/componentes/menu_control.css",
                "@estilos/paginas/admin/nucleos.css" // Estilo específico (lo crearemos luego)
            ]
        ]);

        $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/admin.php'));
        $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/nucleos.php'));

        $this->renderizar([
            'nucleos' => $nucleos
        ]);
    }

    private function procesarAccion() {
        $accion = $_POST['accion'] ?? '';
        $id = $_POST['id'] ?? null;

        try {
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
        } catch (\Exception $e) {
            // Deberíamos agregar un sistema de notificaciones/sesiones flash para mostrar errores
            // Por ahora, morimos para ver el error durante el desarrollo
            die("Error: " . $e->getMessage());
        }
        
        header('Location: ' . colocar_enlace('admin/nucleos'));
        exit;
    }
}
