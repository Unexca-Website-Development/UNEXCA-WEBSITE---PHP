<?php
require_once colocar_ruta_sistema('@servicios/paginas/FaqsServicio.php');

$servicio = new \Servicios\Paginas\FaqsServicio();

$data_faqs = $servicio->obtenerDatosFaqs();

$head_data = [
    "title" => "Preguntas Frecuentes - UNEXCA",
    "styles" => [
        "@estilos/componentes/desplegable.css"
    ],
    "meta" => [
        "description" => "Sección de preguntas frecuentes de la UNEXCA, con información sobre nuestros servicios y funcionamiento.",
        "keywords" => "UNEXCA, universidad, FAQs, preguntas frecuentes, información, educación",
    ]
];
