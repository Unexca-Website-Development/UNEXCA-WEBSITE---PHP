<?php

return [
    'sistema' => [
        '@componentes' => __DIR__ . '/vista/componentes',
        '@controlador' => __DIR__ . '/controlador',
        '@estilos'     => __DIR__ . '/vista/estilos',
        '@imagenes'    => __DIR__ . '/publico/imagenes',
        '@modelo'      => __DIR__ . '/modelo',
        '@paginas'     => __DIR__ . '/vista/paginas',
        '@plantilla'   => __DIR__ . '/vista/plantilla',
        '@scripts'     => __DIR__ . '/vista/scripts',
        '@vista'       => __DIR__ . '/vista',
    ],
    'html' => [
        '@componentes' => '/vista/componentes',
        // '@controlador' => '/controlador',
        '@estilos'     => '/vista/estilos',
        '@imagenes'    => '/publico/imagenes',
        // '@modelo'      => '/modelo',
        // '@paginas'     => '/vista/paginas',
        // '@plantilla'   => '/vista/plantilla',
        '@scripts'     => '/vista/scripts',
        // '@vista'       => '/vista',
    ]
];