<?php
require_once colocar_ruta_sistema('@controlador/BaseAdminControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/admin/NoticiasEditorServicio.php');

class AdminNoticiasControlador extends BaseAdminControlador {

    private $servicio;

    public function __construct() {
        parent::__construct();
        $this->servicio = new \Servicios\Paginas\Admin\NoticiasEditorServicio();
    }

    public function index(array $params = []): void 
    {
        $noticiaData = null;
        $id = $params['id'] ?? null;

        if ($id) {
            $noticiaData = $this->servicio->cargarNoticia($id);
        }

        $this->establecerHead([
            "title" => ($id ? "Editar" : "Nueva") . " Noticia - UNEXCA",
            "styles" => [
                "@estilos/paginas/admin/general.css",
                "@estilos/paginas/editorNoticias.css"
            ],
            "meta" => [
                "description" => "Editor de Noticias.",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/admin/noticias.php'));
        $this->renderizar([
            'noticiaData' => $noticiaData
        ]);
    }

    /**
     * Procesa la petición AJAX del editor para guardar la noticia.
     */
    public function GuardarNoticia(array $params): void
    {
        // Limpiar cualquier buffer previo para evitar que se cuele HTML o avisos
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        header('Content-Type: application/json');

        try {
            $resultado = $this->servicio->guardarNoticia($params);

            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'id'      => $resultado,
                    'mensaje' => 'Noticia guardada con éxito'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'mensaje' => 'Error al guardar la noticia'
                ]);
            }
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'mensaje' => 'Error interno: ' . $e->getMessage()
            ]);
        }
        exit;
    }
}

