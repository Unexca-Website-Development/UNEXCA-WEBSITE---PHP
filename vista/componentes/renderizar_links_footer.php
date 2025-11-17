<?php

/**
 * Renderiza las columnas de enlaces del footer.
 *
 * Estructura esperada del arreglo:
 * $data_array = [
 *     'Título columna' => [
 *         'submenu' => [
 *             'Texto del enlace' => 'url',
 *             ...
 *         ]
 *     ],
 *     ...
 * ];
 *
 * Comportamiento:
 *  - Imprime un contenedor con múltiples columnas.
 *  - Cada columna tiene un título y una lista de enlaces.
 *  - Aplica htmlspecialchars a títulos, textos de enlaces y URLs.
 *  - No realiza validación profunda porque el servicio debe entregar la
 *    estructura ya depurada.
 *
 * Parámetros:
 * @param array $data_array Arreglo generado por el servicio del footer.
 *
 * Retorna:
 * @return void
 */

function renderizar_links_footer($data_array) {
    ?>
    <div class="footer__links">
        <ul class="footer__grupo-columnas">
            <?php foreach ($data_array as $titulo => $info): ?>
                <li class="footer__columna">
                    <p class="footer__titulo"><?= htmlspecialchars($titulo) ?></p>
                    <ul class="footer__lista">
                        <?php foreach ($info['submenu'] as $texto => $url): ?>
                            <li class="footer__item">
                                <a href="<?= htmlspecialchars($url) ?>"><?= htmlspecialchars($texto) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
}