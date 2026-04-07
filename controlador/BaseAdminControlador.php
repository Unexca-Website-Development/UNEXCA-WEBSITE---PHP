<?php
/**
 * Clase BaseAdminControlador
 * 
 * Controlador base para todas las páginas del panel administrativo.
 * Maneja la autenticación obligatoria y la carga de datos comunes (menú).
 */

require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/nucleo/AuthServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaAdminServicio.php');

class BaseAdminControlador extends BaseControlador {

    protected $authServicio;
    protected $servicioAdmin;
    protected $dataMenuControl;

    public function __construct() {
        // Inicializar servicios
        $this->authServicio = new \Servicios\Nucleo\AuthServicio();
        $this->servicioAdmin = new \Servicios\Plantilla\PlantillaAdminServicio();

        // Verificar autenticación
        if (!$this->authServicio->estaAutenticado()) {
            header('Location: ' . colocar_enlace('login'));
            exit;
        }

        // Cargar datos comunes para la plantilla admin
        $this->dataMenuControl = $this->servicioAdmin->obtenerMenuControl();
        
        // Establecer plantilla administrativa por defecto
        $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/admin/admin.php'));
    }

    /**
     * Sobrescribe el método renderizar para incluir siempre el menú de control.
     */
    protected function renderizar(array $datos = []): void {
        $datos['data_menu_control'] = $this->dataMenuControl;
        parent::renderizar($datos);
    }
}
