<?php
/**
 * links_header
 *
 * Genera la lista de links del header de la web, soportando submenús.
 *
 * Cada link puede ser:
 *  - Un enlace simple (<a>).
 *  - Un botón con submenú (<button> + <ul>) si el link tiene 'submenu'.
 *
 * Estructura esperada de $data_array:
 * [
 *     'Nombre del link' => [
 *         'url' => '...',           // URL del enlace principal
 *         'submenu' => [             // Opcional, arreglo de subenlaces
 *             'Texto del sublink' => 'url',
 *             ...
 *         ]
 *     ],
 *     ...
 * ]
 *
 * Parámetros:
 * @param array $data_array Arreglo asociativo de links y submenús.
 *
 * Retorna:
 * Imprime directamente el HTML del menú del header.
 */
function links_header($data_array) {
    ?>
    <nav class="header__nav">
        <ul class="header__menu">
            <?php foreach ($data_array as $nombre => $info): 
                $tiene_sub_menu = !empty($info['submenu']) && is_array($info['submenu']);
            ?>
                <li class="header__menu-item <?= $tiene_sub_menu ? 'header__menu-item--con-submenu' : '' ?>">
                    <?php if ($tiene_sub_menu): ?>
                        <button class="header__menu-link header__link-boton" aria-expanded="false" aria-controls="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>">
                            <span class="header__link-boton-texto">
                                <?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>
                            </span>
                            <?= colocar_svg('@imagenes/iconos/flecha.svg') ?>
                        </button>
                    <?php else: ?>
                        <a href="<?= htmlspecialchars($info['url'], ENT_QUOTES, 'UTF-8') ?>" class="header__menu-link">
                            <?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($tiene_sub_menu): ?>
                        <ul class="header__sub-menu">
                            <?php foreach ($info['submenu'] as $texto => $url): ?>
                                <li class="header__sub-menu-item">
                                    <a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>" class="header__sub-menu-link">
                                        <?= htmlspecialchars($texto, ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
}