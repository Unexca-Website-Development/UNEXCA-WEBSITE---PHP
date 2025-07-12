<?php include colocar_ruta_sistema('@componentes/header_nav.php'); ?>
<header>
    <div class="contenedor-nav">
        <a href="" class="logo-menu">
            <?= colocar_svg('@imagenes/logo_menu.svg')?>
        </a> 
        <?php renderizar_menu($data_ejemplo) ?>
    </div>
    <?= colocar_svg('@imagenes/decoracion.svg') ?>
</header>