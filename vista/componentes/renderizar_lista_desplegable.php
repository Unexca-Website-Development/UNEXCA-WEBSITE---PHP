<?php
function renderizar_lista_desplegable($data_array) {
    echo '<div class="desplegable">';
    foreach ($data_array as $item) {
        ?>
        <div class="desplegable__item">
            <button class="desplegable__titulo" aria-expanded="false" aria-controls="contenido-<?= $item['id'] ?>">
                <?= htmlspecialchars($item['titulo']) ?>
                <?= colocar_svg('@imagenes/iconos/flecha.svg') ?>
            </button>
            <div id="contenido-<?= $item['id'] ?>" class="desplegable__contenido">
                <p class="desplegable__parrafo"><?= htmlspecialchars($item['contenido']) ?></p>
            </div>
        </div>
        <?php
    }
    echo '</div>';
}
