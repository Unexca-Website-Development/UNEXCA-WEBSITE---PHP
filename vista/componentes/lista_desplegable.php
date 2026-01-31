<?php

/**
 * lista_desplegable
 *
 * Genera un componente HTML de lista desplegable a partir de un arreglo de datos.
 *
 * Cada elemento se muestra como un bloque con un botón que expande/cierra
 * su contenido correspondiente.
 *
 * Estructura esperada de $data_array:
 * [
 *     [
 *         'id' => string|int,       // Identificador único del ítem (usado en id del contenido)
 *         'titulo' => string,       // Título que aparece en el botón
 *         'contenido' => string,    // Texto que se despliega al hacer click
 *     ],
 *     ...
 * ]
 *
 * @param array $data_array Arreglo de ítems a renderizar.
 * @return void Este componente imprime directamente el HTML.
 */

function lista_desplegable($data_array) {
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
