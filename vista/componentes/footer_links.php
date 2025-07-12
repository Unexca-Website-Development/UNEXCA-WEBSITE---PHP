<?php 

require_once __DIR__ . '/funciones.php'; 

// Esta es una data de prueba
    $data_ejemplo = [
        "La Unexca" => [
            "url" => "#",
            "submenu" => [
                "Historia" => "history.html",
                "Misión, Visión y Valores" => "history.html#mis-vi-va",
                "Autoridades Universitarias" => "autoridades.html",
            ],
        ],
        "Programas Académicos" => [
            "url" => "index.html#carr_link",
            "submenu" => [],
        ],
        "Noticias" => [
            "url" => "index.html#noti_link",
            "submenu" => [],
        ],
        "Acerca de..." => [
            "url" => "#",
            "submenu" => [
                "Servicios" => "servicios.html",
                "Contactos" => "contacto.html",
                "Preguntas Frecuentes" => "faqs.html",
            ],
        ],
    ];

function renderizar_links_footer($data_ejemplo) {
    ?>
    
    <?php
}