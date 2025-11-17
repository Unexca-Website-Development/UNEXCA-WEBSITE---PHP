<?php
/**
 * Archivo de configuración de rutas del proyecto.
 *
 * Define rutas absolutas del sistema y rutas relativas para uso en HTML.
 * 
 * - 'sistema': rutas del servidor para incluir archivos PHP mediante colocar_ruta_sistema().
 * - 'html': rutas relativas para uso en elementos HTML (src, href, etc.) mediante colocar_ruta_html().
 *
 * No contiene lógica adicional, solo retorna un array asociativo con las rutas.
 */
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
        '@estilos'     => '/estilos',
        '@imagenes'    => '/imagenes',
        '@scripts'     => '/scripts',
    ]
];