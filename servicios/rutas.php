<?php

return [

    ['GET', 'inicio', 'InicioControlador@index'],

    ['GET', 'historia', 'HistoriaControlador@index'],
    ['GET', 'mision-vision-valores', 'MisionVisionValoresControlador@index'],
    ['GET', 'autoridades', 'AutoridadesControlador@index'],
    ['GET', 'faqs', 'FaqsControlador@index'],
    ['GET', 'servicios', 'ServiciosControlador@index'],
    ['GET', 'contactos', 'ContactosControlador@index'],
    ['GET', 'carrera', 'CarreraControlador@mostrar'],
    ['GET', 'nucleos', 'NucleosControlador@index'],

    // Rutas Administrativas <- AnthoFu estuvo aqui
    ['GET', 'admin', 'AdminControlador@index'],
    ['GET', 'login', 'AuthControlador@mostrarLogin'],
    ['POST', 'login', 'AuthControlador@login'],
    ['GET', 'logout', 'AuthControlador@logout'],

    ['GET', 'admin-noticias', 'AdminNoticiasControlador@index'],
    ['POST', 'admin-noticias', 'AdminNoticiasControlador@GuardarNoticia'],
    
    // Módulo de Autoridades
    ['GET', 'admin-autoridades', 'AdminAutoridadesControlador@index'],
    ['POST', 'admin-autoridades', 'AdminAutoridadesControlador@procesarAccion'],

    // Módulo de Núcleos
    ['GET', 'admin-nucleos', 'AdminNucleosControlador@index'],
    ['POST', 'admin-nucleos', 'AdminNucleosControlador@procesarAccion'],

    // Rutas de subida de imágenes
    ['POST', 'admin-subir-imagen-autoridad', 'AdminImagenesControlador@subirAutoridad'],
    ['POST', 'admin-subir-imagen-nucleo', 'AdminImagenesControlador@subirNucleo'],
    ['POST', 'admin-subir-imagen-noticia', 'AdminImagenesControlador@subirNoticia'],

    ['GET', 'admin-opciones', 'AdminControlador@index'],
];
