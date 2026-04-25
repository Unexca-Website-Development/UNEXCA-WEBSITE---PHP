<?php
require_once colocar_ruta_sistema('@controlador/BaseAdminControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/admin/AdminNucleosServicio.php');

class AdminNucleosControlador extends BaseAdminControlador {
        private $servicio;

        public function __construct() {
            parent::__construct();
            $this->servicio = new \Servicios\Paginas\Admin\AdminNucleosServicio();
        }

    public function index(array $params = []): void {
        $nucleos = $this->servicio->obtenerTodos();

        $this->establecerHead([
            "title" => "Gestión de Núcleos - UNEXCA",
            "styles" => [
                "@estilos/paginas/admin/general.css"
                ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/nucleos.php'));

        $this->renderizar([
            'nucleos' => $nucleos
        ]);
    }

    public function procesarAccion(array $params = []): void {

        $accion = $params['accion'] ?? '';
        $id = $params['id'] ?? null;

        try {
            switch ($accion) {
                case 'guardar':
                    $datos = [
                        'nombre' => $params['nombre'] ?? '',
                        'direccion' => $params['direccion'] ?? ''
                    ];
                    $imagen = $params['files']['imagen'] ?? null;

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
        } catch (\Throwable $e) {
            die("Error: " . $e->getMessage());
        }

        header('Location: ' . colocar_enlace('admin-nucleos'));
        exit;
    }

}
