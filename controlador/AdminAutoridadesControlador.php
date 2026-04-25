<?php
require_once colocar_ruta_sistema('@controlador/BaseAdminControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/admin/AdminAutoridadesServicio.php');

class AdminAutoridadesControlador extends BaseAdminControlador {

    private $servicio;

    public function __construct() {
        parent::__construct();
        $this->servicio = new \Servicios\Paginas\Admin\AdminAutoridadesServicio();
    }

    public function index(array $params = []): void {

        $autoridades = $this->servicio->obtenerListado();

        $this->establecerHead([
            "title" => "Gestión de Autoridades - UNEXCA",
            "styles" => [
                "@estilos/paginas/admin/general.css"
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/autoridades.php'));

        $this->renderizar([
            'autoridades' => $autoridades
        ]);
    }

    public function procesarAccion(array $params = []) {
        $accion = $params['accion'] ?? '';
        $id = $params['id'] ?? null;

        switch ($accion) {
            case 'guardar':
                $datos = [
                    'nombre' => $params['nombre'] ?? '',
                    'cargo' => $params['cargo'] ?? ''
                ];
                $imagen = $params['files']['imagen'] ?? null;

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
        
        header('Location: ' . colocar_enlace('admin-autoridades'));
        exit;
    }
}
