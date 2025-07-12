<?php

return [
    'sistema' => [
        '@componentes' => __DIR__ . '/vista/componentes',
        '@controlador' => __DIR__ . '/controlador',
        '@estilos'     => __DIR__ . '/publico/estilos',
        '@imagenes'    => __DIR__ . '/publico/imagenes',
        '@modelo'      => __DIR__ . '/modelo',
        '@paginas'     => __DIR__ . '/vista/paginas',
        '@plantilla'   => __DIR__ . '/vista/plantilla',
        '@scripts'     => __DIR__ . '/publico/scripts',
        '@vista'       => __DIR__ . '/vista',
    ],
    'html' => [
        '@componentes' => '/vista/componentes',
        // '@controlador' => '/controlador',
        '@estilos'     => '/publico/estilos',
        '@imagenes'    => '/publico/imagenes',
        // '@modelo'      => '/modelo',
        // '@paginas'     => '/vista/paginas',
        // '@plantilla'   => '/vista/plantilla',
        '@scripts'     => '/publico/scripts',
        // '@vista'       => '/vista',
    ]
];