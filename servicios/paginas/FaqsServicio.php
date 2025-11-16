<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/FaqsModelo.php');

/**
 * Servicio para la página de FAQs.
 *
 * Proporciona métodos para obtener y procesar los datos de preguntas frecuentes
 * desde el modelo para ser consumidos por la vista.
 */
class FaqsServicio
{
    /**
     * @var \Modelo\Paginas\FaqsModelo Instancia del modelo de FAQs.
     */
    private $modelo_faqs;

    /**
     * Constructor.
     *
     * Inicializa el modelo de FAQs.
     */
    public function __construct()
    {
        $this->modelo_faqs = new \Modelo\Paginas\FaqsModelo();
    }

    /**
     * Obtiene los datos de FAQs.
     *
     * Convierte la información de la base de datos en un array listo para la vista.
     *
     * @return array Lista de FAQs con id, título (pregunta) y contenido (respuesta).
     */
    public function obtenerDatosFaqs()
    {
        $faqs_lista = $this->modelo_faqs->obtenerFaqs();
        $faqs_array = [];

        foreach ($faqs_lista as $faq) {
            $faqs_array[] = [
                "id"       => $faq['id'],
                "titulo"   => $faq['pregunta'],
                "contenido"=> $faq['respuesta'],
            ];
        }

        return $faqs_array;
    }
}