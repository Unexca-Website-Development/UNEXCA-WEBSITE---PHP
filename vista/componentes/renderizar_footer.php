<?php
function renderizar_footer(array $data_array = []){
    ?>
        <footer class="footer">
            <?= colocar_svg('@imagenes/decorativos/decoracion.svg') ?>
            <div class="footer__contenido">
                <section class="footer__contenedor">
                    <?php renderizar_links_footer($data_array) ?>

                    <div class="footer__social">
                        <a href="<?= colocar_enlace('inicio'); ?>" class="footer__logo-fondo">
                            <?= colocar_svg('@imagenes/logos/logo_menu.svg') ?>
                        </a>
                        <ul class="footer__redes">
                            <li class="footer__icono-red">
                                <a href="" class="footer__enlace-icono">
                                    <?= colocar_svg('@imagenes/iconos/facebook_logo.svg') ?>
                                </a>
                            </li>
                            <li class="footer__icono-red">
                                <a href="" class="footer__enlace-icono">
                                    <?= colocar_svg('@imagenes/iconos/instagram_logo.svg') ?>
                                </a>
                            </li>
                            <li class="footer__icono-red">
                                <a href="" class="footer__enlace-icono">
                                    <?= colocar_svg('@imagenes/iconos/telegram_logo.svg') ?>
                                </a>
                            </li>
                            <li class="footer__icono-red">
                                <a href="" class="footer__enlace-icono">
                                    <?= colocar_svg('@imagenes/iconos/whatsapp_logo.svg') ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </section>
                <!-- <section class="footer__fondo">
                    <p class="footer__texto">
                        <span class="footer__copyleft">&copy;</span>2025. Universidad Nacional Experimental de la Gran Caracas (UNEXCA).
                    </p>
                </section> -->
            </div>
        </footer>
    <?php
}