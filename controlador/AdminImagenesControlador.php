<?php

require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/admin/ImagenesServicio.php');
require_once colocar_ruta_sistema('@servicios/nucleo/AuthServicio.php');

class AdminImagenesControlador extends BaseControlador {

    private $servicio;
    private $authServicio;

    public function __construct() {
        $this->authServicio = new \Servicios\Nucleo\AuthServicio();
        if (!$this->authServicio->estaAutenticado()) {
            $this->responderJson(['error' => 'No autorizado. Debe iniciar sesión.'], 401);
        }
        $this->servicio = new \Servicios\Paginas\Admin\ImagenesServicio();
    }

    /**
     * Responde con un JSON.
     *
     * @param array $data Los datos a enviar.
     * @param int $statusCode El código de estado HTTP.
     */
    private function responderJson(array $data, int $statusCode = 200): void {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    private function procesarSubida(string $tipoEntidad): void
    {
        try {
            if (!isset($_FILES['imagen'])) {
                throw new \Exception('No se ha enviado ningún archivo.');
            }
            if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
                throw new \Exception('No se ha proporcionado un ID de entidad válido.');
            }

            $idEntidad = (int)$_POST['id'];
            
            $rutaImagen = $this->servicio->subirImagen($_FILES['imagen'], $tipoEntidad, $idEntidad);
            
            $this->responderJson(['ruta' => $rutaImagen]);

        } catch (\Exception $e) {
            $this->responderJson(['error' => $e->getMessage()], 400);
        }
    }

    public function subirAutoridad(): void {
        $this->procesarSubida('autoridad');
    }

    public function subirNucleo(): void {
        $this->procesarSubida('nucleo');
    }

    public function subirNoticia(): void {
        $this->procesarSubida('noticia');
    }
}
