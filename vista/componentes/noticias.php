<?php

/**
 * noticias
 *
 * Renderiza hasta 4 noticias en formato de tarjetas modernas.
 *
 * Cada tarjeta incluye:
 *  - Imagen de la noticia.
 *  - Título de la noticia.
 *  - Descripción corta.
 *  - Enlace de "Leer Más".
 *
 * Estructura esperada de $data_array:
 * [
 *     [
 *         'img' => string,         // Ruta relativa de la imagen
 *         'titulo' => string,      // Título
 *         'descripcion' => string, // Descripción corta
 *         'link' => string,        // URL
 *     ],
 *     ...
 * ]
 *
 * @param array $data_array Arreglo de noticias a renderizar.
 * @return void
 */

function noticias($data_array){
    $contador = 0;
    foreach ($data_array as $noticia) {
        if ($contador >= 4) break;
        ?>
        <article class="noticia">
            <div class="noticia__imagen">
                <img src="<?= resolver_url_asset($noticia['img']) ?>" alt="<?= htmlspecialchars($noticia['titulo']) ?>">
            </div>
            <div class="noticia__contenido">
                <div class="noticia__contenedor-texto">
                    <h3 class="noticia__titulo">
                        <?= htmlspecialchars($noticia['titulo']) ?>
                    </h3>
                    <p class="noticia__descripcion">
                        <?= htmlspecialchars($noticia['descripcion'] ?? '') ?>
                    </p>
                </div>
                <a class="noticia__enlace" href="<?= htmlspecialchars($noticia['link']) ?>">
                    Leer Más
                    <?= colocar_svg('@imagenes/iconos/flecha.svg'); ?>
                </a>
            </div>
        </article>
        <?php
        $contador++;
    }
}