<?php

/**
 * noticias
 *
 * Renderiza hasta 4 noticias en formato de tarjetas.
 *
 * Cada tarjeta incluye:
 *  - Imagen de la noticia con enlace.
 *  - Título de la noticia con enlace.
 *
 * Estructura esperada de $data_array:
 * [
 *     [
 *         'img' => string,       // Ruta relativa de la imagen de la noticia
 *         'title' => string,     // Título de la noticia
 *         'link' => string,      // URL a la noticia completa o recurso relacionado
 *     ],
 *     ...
 * ]
 *
 * @param array $data_array Arreglo de noticias a renderizar.
 * @return void Este componente imprime directamente el HTML.
 */

function noticias($data_array){
    $contador = 0;
    foreach ($data_array as $noticia) {

        // Cuantas carreras renderizar
        if ($contador >= 4) break;

        ?>
        <article class="noticia">
            <figure class="noticia__imagen">
                <a class="noticia__enlace" href="<?= htmlspecialchars($noticia['link']) ?>">
                    <img class="noticia__img" src="<?= colocar_ruta_html("@imagenes/carreras/") . htmlspecialchars(ltrim($noticia['img'], '/')) ?>" alt="<?= htmlspecialchars($noticia['titulo']) ?>">
                </a>
            </figure>

            <div class="noticia__contenido">
                <a class="noticia__titulo" href="<?= htmlspecialchars($noticia['link']) ?>">
                    <?= htmlspecialchars($noticia['titulo']) ?>
                </a>
            </div>
        </article>
        <?php
        
        $contador++;
    }
}