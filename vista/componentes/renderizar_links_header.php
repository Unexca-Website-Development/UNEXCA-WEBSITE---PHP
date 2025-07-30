<?php
function renderizar_links_header($data_array) {
    ?>
    <nav class="header__nav">
        <ul class="header__menu">
            <?php 
                // Itera la data que resive
                foreach ($data_array as $nombre => $info):

                // Guarda true si no esta vacio el array y false si lo esta.
                // Ademas se asegura de que sea un array valido
                $tiene_sub_menu = !empty($info['submenu']) && is_array($info['submenu']);
            ?>
                <li class="header__menu-item <?= $tiene_sub_menu ? 'header__menu-item--con-submenu' : '' ?>">
                    <a href="<?= htmlspecialchars($info['url'] ?? '#', ENT_QUOTES, 'UTF-8') ?>" class="header__menu-link">
                        <?= htmlspecialchars($nombre ?? 'Enlace', ENT_QUOTES, 'UTF-8') ?>
                        <?= $tiene_sub_menu ? colocar_svg('@imagenes/flecha.svg') : '' ?>
                    </a>

                    <?php if ($tiene_sub_menu): ?>
                        <ul class="header__sub-menu">
                            <?php foreach ($info['submenu'] as $texto => $url): ?>
                                <li class="header__sub-menu-item">
                                    <a href="<?= htmlspecialchars($url ?? '#', ENT_QUOTES, 'UTF-8') ?>" class="header__sub-menu-link">
                                        <?= htmlspecialchars($texto ?? 'Default', ENT_QUOTES, 'UTF-8') ?>
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