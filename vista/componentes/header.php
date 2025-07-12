<?php include colocar_ruta_sistema('@componentes/header_links.php'); ?>
<header>
    <div class="contenedor-nav">
        <a href="" class="logo-menu">
            <?= colocar_svg('@imagenes/logo_menu.svg')?>
        </a> 
        <?php renderizar_links_header($data_ejemplo) ?>
    </div>
    <?= colocar_svg('@imagenes/decoracion.svg') ?>
</header>