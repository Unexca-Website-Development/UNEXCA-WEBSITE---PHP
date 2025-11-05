<?php

$paginas_permitidas = [
    'inicio' => 'inicio.php',
    'historia' => 'historia.php',
    'mision-vision-valores' => 'mision_vision_valores.php',
    'autoridades' => 'autoridades.php',
    'faqs' => 'faqs.php',
    'servicios' => 'servicios.php',
    'carrera' => 'carrera.php',
    'contactos' => 'contactos.php',
    'noticias' => 'noticias.php',
];

$paginas_desarrollo = [
    'noticias-editor' => 'noticias_editor.php',
];

return [
    'paginas' => $paginas_permitidas,
    'desarrollo' => $paginas_desarrollo,
];