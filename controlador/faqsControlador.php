<?php   
require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/paginas/FaqsServicio.php');
require_once colocar_ruta_sistema('@servicios/plantilla/PlantillaDefaultServicio.php');

class FaqsControlador extends BaseControlador {

    public function index(): void {
        $servicio = new \Servicios\Paginas\FaqsServicio();
        $servicio_plantilla = new \Servicios\Plantilla\PlantillaDefaultServicio();

        $data_faqs = $servicio->obtenerDatosFaqs();
        $data_header = $servicio_plantilla->obtenerDatosMenu('Header');
        $data_footer = $servicio_plantilla->obtenerDatosMenu('Footer');

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
            'data_faqs' => $data_faqs,
            'data_header'  => $data_header,
            'data_footer'  => $data_footer
        ]);
    }
}