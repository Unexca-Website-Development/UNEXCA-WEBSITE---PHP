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
        $listaNoticias = null;
        $id = $params['id'] ?? null;
        $nueva = isset($params['nueva']);

        // Si se pide una nueva o editar una, cargamos datos para el editor
        if ($nueva || $id) {
            if ($id) {
                $noticiaData = $this->servicio->cargarNoticia($id);
            }
        } else {
            // Si no, cargamos la lista
            $listaNoticias = $this->servicio->listarNoticias();
        }

        $this->establecerHead([
            "title" => "Gestión de Noticias - UNEXCA",
            "styles" => [
                "@estilos/paginas/admin/general.css",
                "@estilos/paginas/editorNoticias.css"
            ],
            "meta" => [
                "description" => "Gestión de Noticias.",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/admin/noticias.php'));
        $this->renderizar([
            'noticiaData'   => $noticiaData,
            'listaNoticias' => $listaNoticias,
            'modoEditor'    => ($nueva || $id)
        ]);
    }

    /**
     * Procesa la eliminación de una noticia.
     */
    public function EliminarNoticia(array $params): void
    {
        $id = $params['id'] ?? null;
        if ($id) {
            $this->servicio->eliminarNoticia($id);
        }
        header('Location: ' . colocar_enlace('admin-noticias'));
        exit;
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

