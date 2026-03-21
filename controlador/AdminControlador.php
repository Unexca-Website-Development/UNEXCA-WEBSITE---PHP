<?php
/**
 * Controlador para la página principal del panel administrativo.
 */

require_once colocar_ruta_sistema('@controlador/BaseAdminControlador.php');
require_once colocar_ruta_sistema('@controlador/AdminAutoridadesControlador.php');
require_once colocar_ruta_sistema('@controlador/AdminNucleosControlador.php');
require_once colocar_ruta_sistema('@controlador/AdminNoticiasControlador.php');

class AdminControlador extends BaseAdminControlador {

    public function index(array $params = []): void {
        $seccion = $params['seccion'] ?? 'inicio';

        switch ($seccion) {
            case 'noticias':
                $controlador = new AdminNoticiasControlador();
                $controlador->index($params);
                return;
            case 'autoridades':
                $controlador = new AdminAutoridadesControlador();
                $controlador->index($params);
                return;
            case 'nucleos':
                $controlador = new AdminNucleosControlador();
                $controlador->index($params);
                return;
            case 'inicio':
            default:
                $this->establecerHead([
                    "title" => "Panel de Control - UNEXCA",
                    "styles" => ["@estilos/paginas/admin/general.css"]
                ]);
                $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/inicio.php'));
                $this->renderizar();
                break;
        }
    }

    public function procesarAccion(array $params = []): void {
        $seccion = $params['seccion'] ?? '';

        switch ($seccion) {
            case 'noticias':
                $controlador = new AdminNoticiasControlador();
                $controlador->GuardarNoticia($params);
                return;
            case 'autoridades':
                $controlador = new AdminAutoridadesControlador();
                $controlador->procesarAccion($params);
                return;
            case 'nucleos':
                $controlador = new AdminNucleosControlador();
                $controlador->procesarAccion($params);
                return;
        }

        // Si no hay sección o no coincide, volver al inicio
        header('Location: ' . colocar_enlace('admin'));
        exit;
    }
}
