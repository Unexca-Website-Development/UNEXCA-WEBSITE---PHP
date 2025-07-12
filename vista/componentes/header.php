<?php
require_once __DIR__ . '/../../funciones.php';
include colocar_ruta_sistema('@componentes/header_nav.php');
?>
<link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/header.css')?>">
<header>
    <a href="" class="logo-menu">
        <?= colocar_svg('@imagenes/logo_menu.svg')?>
    </a>
    <?php renderizar_menu($data_ejemplo) ?>
</header>


