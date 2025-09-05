<?php
function renderizar_header(array $data_array = []){
    ?>
        <header class="header">
            <div class="header__contenedor">
                <div class="header__contenedor-nav">
                    <a href="<?= colocar_enlace('inicio'); ?>" class="header__logo-menu">
                        <?= colocar_svg('@imagenes/logos/logo_menu.svg') ?>
                    </a> 
                    <?php renderizar_links_header($data_array) ?>
                </div>
            </div>
            <?= colocar_svg('@imagenes/decorativos/decoracion.svg') ?>
        </header>
    <?php
}
