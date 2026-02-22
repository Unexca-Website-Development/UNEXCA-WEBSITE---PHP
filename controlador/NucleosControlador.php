<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/NucleosServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');
class NucleosControlador extends BaseControlador {
    private $servicio_nucleos;
    private $servicio_plantilla;
    public function __construct() {
        $this->servicio_nucleos = new \Servicios\Paginas\NucleosServicio();
        $this->servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();
    }
    /**
     * Muestra la vista principal (listado y formulario)
     */
    public function index(): void {
        $data_nucleos = $this->servicio_nucleos->obtenerTodos();
        $data_header = $this->servicio_plantilla->obtenerDatosMenu('Header');
        $data_footer = $this->servicio_plantilla->obtenerDatosMenu('Footer');
        $this->establecerHead([
            "title" => "Gestión de Núcleos - UNEXCA",
            "styles" => ["@estilos/paginas/nucleos.css"],
        ]);
        $this->establecerVista(colocar_ruta_sistema('@paginas/nucleos.php'));
        $this->renderizar([
            'data_nucleos' => $data_nucleos,
            'data_header'  => $data_header,
            'data_footer'  => $data_footer
        ]);
    }
    /**
     * Guarda un nuevo núcleo
     */
    public function guardar(...$args): void {
        try {
            $archivo = $_FILES['imagen'] ?? null;
            $this->servicio_nucleos->guardar($_POST, $archivo);
        } catch (\Exception $e) {
            // Manejo simplificado, se podría enviar el error a la vista o usar mensajes de sesión
        }
        $this->redireccionar();
    }
    /**
     * Actualiza un núcleo existente
     */
    public function actualizar(...$args): void {
        try {
            $id = $_POST['id'] ?? null;
            $archivo = $_FILES['imagen'] ?? null;
            if ($id) {
                $this->servicio_nucleos->actualizar($id, $_POST, $archivo);
            }
        } catch (\Exception $e) {
            die("Error al actualizar: " . $e->getMessage());
        }
        $this->redireccionar();
    }
    /**
     * Elimina un núcleo
     */
    public function eliminar(...$args): void {
        try {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $this->servicio_nucleos->eliminar($id);
            }
        } catch (\Exception $e) {}
        $this->redireccionar();
    }
    private function redireccionar() {
        $url = colocar_enlace('nucleos');
        header("Location: " . ltrim($url, '/'));
        exit;
    }
}