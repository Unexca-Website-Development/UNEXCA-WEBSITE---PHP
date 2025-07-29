<?php 

$data_ejemplo_noticias = [
    [
        "title" => "The truly impactful technologies are always based on the condition that you can freely explore.",
        "link" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "The truly impactful technologies are always based on the condition that you can freely explore.",
        "link" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "The truly impactful technologies are always based on the condition that you can freely explore.",
        "link" => "#",
        "img" => "contaduria-foto.jpg",
    ],
    [
        "title" => "The truly impactful technologies are always based on the condition that you can freely explore.",
        "link" => "#",
        "img" => "contaduria-foto.jpg",
    ],
];

function renderizar_noticias($data_ejemplo_noticias){
    $contador = 0;
    foreach ($data_ejemplo_noticias as $noticia) {

        if ($contador >= 4) break;
        ?>
        <article class="noticia">
            <figure class="noticia__imagen">
                <a class="noticia__enlace" href="<?= colocar_ruta_html("@imagenes/") . htmlspecialchars($noticia['link']) ?>">
                    <img class="noticia__img" src="<?= colocar_ruta_html("@imagenes/") . htmlspecialchars(ltrim($noticia['img'], '/')) ?>" alt="<?= htmlspecialchars($noticia['title']) ?>">
                </a>
            </figure>

            <div class="noticia__contenido">
                <a class="noticia__titulo" href="<?= colocar_ruta_html("@imagenes/") . htmlspecialchars($noticia['link']) ?>">
                    <?= htmlspecialchars($noticia['title']) ?>
                </a>
            </div>
        </article>
        <?php
        $contador++;
    }
}