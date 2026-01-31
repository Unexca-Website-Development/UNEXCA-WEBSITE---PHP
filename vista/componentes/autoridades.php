<?php
/**
 * autoridades
 *
 * Genera una lista HTML de autoridades académicas a partir de un arreglo de datos.
 *
 * Cada autoridad se muestra con su imagen, nombre y cargo en un elemento <li>.
 *
 * Estructura esperada de $data_array:
 * [
 *     [
 *         'nombre' => string,     // Nombre completo de la autoridad
 *         'cargo' => string,      // Cargo o título de la autoridad
 *         'imagen' => string,     // Ruta relativa a la imagen de la autoridad
 *     ],
 *     ...
 * ]
 *
 * @param array $data_array Arreglo de autoridades a renderizar.
 * @return void Este componente imprime directamente el HTML.
 */
function autoridades($data_array) {
        ?>
            <ul class="autoridad__lista">
                <?php foreach($data_array as $autoridad): ?>
                    <li class="autoridad__item">
                        <div class="autoridad__imagen">
                            <img class="autoridad__img" src="<?= colocar_ruta_html("@imagenes/autoridades/") . htmlspecialchars(ltrim($autoridad['imagen'], '/')) ?>" alt="Imagen de <?= htmlspecialchars($autoridad['nombre']) ?>">
                        </div>

                        <div class="autoridad__texto">
                            <h3 class="autoridad__nombre"><?= htmlspecialchars($autoridad['nombre']) ?></h3>
                            <p class="autoridad__cargo"><?= htmlspecialchars($autoridad['cargo']) ?></p>
                        </div>
                    </li>
                <?php endforeach;?>
            </ul>
        <?php
}