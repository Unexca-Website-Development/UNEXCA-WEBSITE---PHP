<?php
function renderizar_footer(array $data_array = []){
    ?>
        <footer class="footer">
            <?= colocar_svg('@imagenes/decoracion.svg') ?>
            <div class="footer__contenedor">
                
                <?php renderizar_links_footer($data_array) ?>

                <div class="footer__fondo">

                    <a href="<?= colocar_enlace('inicio'); ?>" class="footer__logo-fondo">
                        <?= colocar_svg('@imagenes/logo_menu.svg') ?>
                    </a>
                    
                    <p class="footer__texto">
                        <span class="footer__copyleft">&copy;</span>2025. Universidad Nacional Experimental de la Gran Caracas (UNEXCA).
                    </p>
                    <ul class="footer__redes">
                        <li class="footer__icono-red">
                            <a href="" class="footer__enlace-icono">
                                <?= colocar_svg('@imagenes/facebook_logo.svg') ?>
                            </a>
                        </li>
                        <li class="footer__icono-red">
                            <a href="" class="footer__enlace-icono">
                                <?= colocar_svg('@imagenes/instagram_logo.svg') ?>
                            </a>
                        </li>
                        <li class="footer__icono-red">
                            <a href="" class="footer__enlace-icono">
                                <?= colocar_svg('@imagenes/telegram_logo.svg') ?>
                            </a>
                        </li>
                        <li class="footer__icono-red">
                            <a href="" class="footer__enlace-icono">
                                <?= colocar_svg('@imagenes/whatsapp_logo.svg') ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    <?php
}