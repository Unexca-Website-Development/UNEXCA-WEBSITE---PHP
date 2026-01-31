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

    ['GET', 'test', 'TestControlador@index'],
    ['POST', 'test_api', 'TestApiControlador@mostrar'],
];
