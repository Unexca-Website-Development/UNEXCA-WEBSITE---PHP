<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/FaqsModelo.php');

class FaqsServicio
{
    private $modelo_faqs;

    public function __construct()
    {
        $this->modelo_faqs = new \Modelo\Paginas\FaqsModelo();
    }

    public function obtenerDatosFaqs()
    {
        $faqs_lista = $this->modelo_faqs->obtenerFaqs();
        $faqs_array = [];

        foreach ($faqs_lista as $faq) {

            $faqs_array[] = [
                "id" => $faq['id'],
                "titulo" => $faq['pregunta'],
                "contenido" => $faq['respuesta'],
            ];
        }
        
        return $faqs_array;
    }
};
