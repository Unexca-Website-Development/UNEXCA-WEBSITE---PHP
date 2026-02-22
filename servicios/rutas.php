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

    ['GET', 'noticias_editor', 'NoticiasEditorControlador@Index'],
    ['POST', 'noticias_editor', 'NoticiasEditorControlador@GuardarNoticia'],

    // Rutas Administrativas <- AnthoFu estuvo aqui
    ['GET', 'admin', 'AdminControlador@index'],
    ['GET', 'admin/noticias', 'AdminControlador@index'],
    
    // Módulo de Autoridades
    ['GET', 'admin/autoridades', 'AdminAutoridadesControlador@index'],
    ['POST', 'admin/autoridades', 'AdminAutoridadesControlador@index'],

    // Módulo de Núcleos
    ['GET', 'admin/nucleos', 'AdminNucleosControlador@index'],
    ['POST', 'admin/nucleos', 'AdminNucleosControlador@index'],

    ['GET', 'admin/opciones', 'AdminControlador@index'],
];
