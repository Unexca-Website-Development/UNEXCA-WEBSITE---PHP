<?php   
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/FaqsServicio.php');

class FaqsControlador extends BaseControlador {

    public function index(): void {
        $servicio = new \Servicios\Paginas\FaqsServicio();
        $data_faqs = $servicio->obtenerDatosFaqs();

        $this->establecerHead([
            "title" => "Preguntas Frecuentes - UNEXCA",
            "styles" => [
                "@estilos/componentes/desplegable.css"
            ],
            "meta" => [
                "description" => "Sección de preguntas frecuentes de la UNEXCA, con información sobre nuestros servicios y funcionamiento.",
                "keywords" => "UNEXCA, universidad, FAQs, preguntas frecuentes, información, educación",
            ]
        ]);

        $this->establecerVista(colocar_ruta_sistema('@paginas/faqs.php'));

        $this->renderizar([
            'data_faqs' => $data_faqs
        ]);
    }
}