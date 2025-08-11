<?php 
function renderizar_noticias($data_array){
    $contador = 0;
    foreach ($data_array as $noticia) {

        // Cuantas carreras renderizar
        if ($contador >= 4) break;

        ?>
        <article class="noticia">
            <figure class="noticia__imagen">
                <a class="noticia__enlace" href="<?= colocar_ruta_html("@imagenes/") . htmlspecialchars($noticia['link']) ?>">
                    <img class="noticia__img" src="<?= colocar_ruta_html("@imagenes/carreras/") . htmlspecialchars(ltrim($noticia['img'], '/')) ?>" alt="<?= htmlspecialchars($noticia['title']) ?>">
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