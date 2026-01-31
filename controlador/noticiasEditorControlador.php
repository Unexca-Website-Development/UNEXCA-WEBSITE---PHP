<?php
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');

class noticiasEditorControlador extends BaseControlador {

    public function index(): void {
        $this->establecerHead([
            "title" => "Editor de Noticias (Prueba) - UNEXCA",
            "styles" => ["@estilos/paginas/editorNoticias.css"],
            "meta" => [
                "description" => "Editor de Noticias en Prueba.",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/noticias_editor.php'));

        $this->renderizar();
    }
}
