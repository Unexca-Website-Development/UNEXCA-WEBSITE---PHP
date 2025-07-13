<?php 
    require_once __DIR__ . '/../../funciones.php';
    include colocar_ruta_sistema('@componentes/footer_links.php')
?>
<link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/index.css')?>">
<link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/footer.css')?>">

<footer class="footer-principal">
    <?= colocar_svg('@imagenes/decoracion.svg') ?>
    <div class="footer-contenedor">
        <?php renderizar_links_footer($data_ejemplo) ?>
        <div class="footer-fondo">
            <?= colocar_svg('@imagenes/logo_menu.svg') ?>
            <p class="fondo-texto"><span class="copyleft">&copy;</span>2025. Universidad Nacional Experimental de la Gran Caracas (UNEXCA).</p>
            <ul class="social">
                <li class="social-icon">
                    <a href="" class="icon-link">
                        <?= colocar_svg('@imagenes/facebook_logo.svg') ?>
                    </a>
                </li>
                <li class="social-icon">
                    <a href="" class="icon-link">
                        <?= colocar_svg('@imagenes/instagram_logo.svg') ?>
                    </a>
                </li>
                <li class="social-icon">
                    <a href="" class="icon-link">
                        <?= colocar_svg('@imagenes/telegram_logo.svg') ?>
                    </a>
                </li>
                <li class="social-icon">
                    <a href="" class="icon-link">
                        <?= colocar_svg('@imagenes/whatsapp_logo.svg') ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>