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

    ['GET', 'noticias_editor', 'NoticiasEditorControlador@Index'],
    ['POST', 'noticias_editor', 'NoticiasEditorControlador@GuardarNoticia'],
];
