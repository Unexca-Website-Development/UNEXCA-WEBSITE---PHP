<?php

return [

    ['GET', '/', 'InicioControlador@index'],
    ['GET', 'inicio', 'InicioControlador@index'],

    ['GET', 'historia', 'HistoriaControlador@index'],
    ['GET', 'mision-vision-valores', 'MisionVisionValoresControlador@index'],
    ['GET', 'autoridades', 'AutoridadesControlador@index'],
    ['GET', 'faqs', 'FaqsControlador@index'],
    ['GET', 'servicios', 'ServiciosControlador@index'],
    ['GET', 'contactos', 'ContactosControlador@index'],

    ['GET', 'carrera', 'CarreraControlador@mostrar'],

    // Rutas Administrativas <- AnthoFu estuvo aqui
    ['GET', 'admin', 'AdminControlador@index'],
    ['GET', 'admin/noticias', 'AdminControlador@index'],
    ['GET', 'admin/autoridades', 'AdminControlador@index'],
    ['GET', 'admin/nucleos', 'AdminControlador@index'],
    ['GET', 'admin/opciones', 'AdminControlador@index'],
];
