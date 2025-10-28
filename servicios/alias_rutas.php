<?php

return [
    'sistema' => [
        '@componentes' => dirname(__DIR__) . '/vista/componentes',
        '@controlador' => dirname(__DIR__) . '/controlador',
        '@estilos'     => dirname(__DIR__) . '/publico/estilos',
        '@imagenes'    => dirname(__DIR__) . '/publico/imagenes',
        '@modelo'      => dirname(__DIR__) . '/modelo',
        '@paginas'     => dirname(__DIR__) . '/vista/paginas',
        '@plantilla'   => dirname(__DIR__) . '/vista/plantilla',
        '@scripts'     => dirname(__DIR__) . '/publico/scripts',
        '@vista'       => dirname(__DIR__) . '/vista',
        '@servicios'   => dirname(__DIR__) . '/servicios',
        '@logs'        => dirname(__DIR__) . '/logs'
    ],
    'html' => [
        // '@componentes' => '/vista/componentes',
        // '@controlador' => '/controlador',
        '@estilos'     => '/estilos',
        '@imagenes'    => '/imagenes',
        // '@modelo'      => '/modelo',
        // '@paginas'     => '/vista/paginas',
        // '@plantilla'   => '/vista/plantilla',
        '@scripts'     => '/scripts',
        // '@vista'       => '/vista',
        // '@servicios'   => '/servicios' 
    ]
];



