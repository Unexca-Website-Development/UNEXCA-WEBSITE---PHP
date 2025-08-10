<?php
require_once colocar_ruta_sistema('@modelo/paginas/FaqsModelo.php');

class FaqsServicio
{
    private $modelo_faqs;

    public function __construct()
    {
        $this->modelo_faqs = new FaqsModelo();
    }

    public function obtenerDatosFaqs()
    {
        $faqs_lista = $this->modelo_faqs->obtenerFaqs();
        $faqs_array = [];

        foreach ($faqs_lista as $faq) {

            $faqs_array[] = [
                "pregunta" => $faq['pregunta'],
                "respuesta" => $faq['respuesta'],
            ];
        }
        
        return $faqs_array;
    }
};
