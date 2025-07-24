<?php

$data_ejemplo_carrera = [
    [
        "title" => "PNF CONTADURIA",
        "descripcion" => "Adquiere profundos conocimientos de las Ciencias Contables y Sociales para ser capaza de elaborar, revisar, examinar, presentar y dar fe publica de la informacion financiera de identidades publicas y privadas.",
        "links" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "PNF CONTADURIA",
        "descripcion" => "Adquiere profundos conocimientos de las Ciencias Contables y Sociales para ser capaza de elaborar, revisar, examinar, presentar y dar fe publica de la informacion financiera de identidades publicas y privadas.",
        "links" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "PNF CONTADURIA",
        "descripcion" => "Adquiere profundos conocimientos de las Ciencias Contables y Sociales para ser capaza de elaborar, revisar, examinar, presentar y dar fe publica de la informacion financiera de identidades publicas y privadas.",
        "links" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "PNF CONTADURIA",
        "descripcion" => "Adquiere profundos conocimientos de las Ciencias Contables y Sociales para ser capaza de elaborar, revisar, examinar, presentar y dar fe publica de la informacion financiera de identidades publicas y privadas.",
        "links" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "PNF CONTADURIA",
        "descripcion" => "Adquiere profundos conocimientos de las Ciencias Contables y Sociales para ser capaza de elaborar, revisar, examinar, presentar y dar fe publica de la informacion financiera de identidades publicas y privadas.",
        "links" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "PNF CONTADURIA",
        "descripcion" => "Adquiere profundos conocimientos de las Ciencias Contables y Sociales para ser capaza de elaborar, revisar, examinar, presentar y dar fe publica de la informacion financiera de identidades publicas y privadas.",
        "links" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "PNF CONTADURIA",
        "descripcion" => "Adquiere profundos conocimientos de las Ciencias Contables y Sociales para ser capaza de elaborar, revisar, examinar, presentar y dar fe publica de la informacion financiera de identidades publicas y privadas.",
        "links" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "PNF CONTADURIA",
        "descripcion" => "Adquiere profundos conocimientos de las Ciencias Contables y Sociales para ser capaza de elaborar, revisar, examinar, presentar y dar fe publica de la informacion financiera de identidades publicas y privadas.",
        "links" => "#",
        "img" => "contaduria-foto.jpg",
    ],
];

function renderizar_carreras($data_ejemplo_carrera) {
    foreach ($data_ejemplo_carrera as $carrera) {
        ?>
        <div class="carrera">
            <div class="carrera__imagen">
                <img src="<?= colocar_ruta_html("@imagenes/") . htmlspecialchars(ltrim($carrera['img'], '/')) ?>" alt="<?= htmlspecialchars($carrera['title']) ?>">
            </div>
            <div class="carrera__contenido">
                <div class="carrera__contenedor-texto">
                    <h3 class="carrera__titulo">
                        <?= htmlspecialchars($carrera['title']) ?>
                    </h3>
                    <p class="carrera__descripcion">
                        <?= htmlspecialchars($carrera['descripcion']) ?>
                    </p>
                </div>
                <a class="carrera__enlace" href="<?= htmlspecialchars($carrera['links']) ?>">
                    Más Información
                    <?= colocar_svg('@imagenes/flecha.svg'); ?>
                </a>
            </div>
        </div>
        <?php
    }
}