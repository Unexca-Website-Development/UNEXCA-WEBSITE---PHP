<?php
require_once __DIR__ . '/../../funciones.php';
include obtenerRutaSistema('@componentes/nav.php');
?>

<header>
    <a href="" class="logo-menu">
        <img src="<?= obtenerRutaHTML('@imagenes/logo_menu.svg')?>" alt="Logo Unexca" class="logo-imagen">
    </a>
    <?php renderizarMenu($data_ejemplo) ?>
</header>


