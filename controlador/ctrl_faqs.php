<?php
require_once colocar_ruta_sistema('@servicios/paginas/FaqsServicio.php');

$servicio = new FaqsServicio();

$data_faqs = $servicio->obtenerDatosFaqs();