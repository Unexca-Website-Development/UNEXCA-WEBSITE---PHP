<?php
/**
 * Renderiza el footer del sitio utilizando datos dinámicos para los enlaces del menú,
 * mientras que el resto del contenido es estático (textos institucionales, decoración y redes sociales).
 *
 * @param array $data_array Arreglo que contiene los enlaces a renderizar en la sección principal del footer.
 *                          Este arreglo es consumido por la función `renderizar_links_footer()`.
 *
 * @return void
 *
 * Uso:
 *  - El controlador prepara los enlaces del menú y los pasa como $data_array.
 *  - Las redes sociales, el año, la decoración y demás contenido son estáticos por diseño
 *    y no dependen de la base de datos ni de servicios.
 */
function renderizar_footer(array $data_array = []){
    ?>
        <footer class="footer">
            <div class="footer__decoracion">
                <?= colocar_svg('@imagenes/decorativos/decoracion.svg') ?>
            </div>
            
            <div class="footer__contenido">
                <section class="footer__contenedor">
                    <?php renderizar_links_footer($data_array) ?>
                </section>
                <section class="footer__fondo">
                    <p class="footer__texto">
                        <span class="footer__copyleft">&copy;</span>2025. Universidad Nacional Experimental de la Gran Caracas (UNEXCA).
                    </p>
                    <div class="footer__social">
                        <ul class="footer__redes">
                            <li class="footer__icono-red">
                                <a href="https://www.facebook.com/UNEXCAcomunicacion" class="footer__enlace-icono">
                                    <?= colocar_svg('@imagenes/iconos/facebook_logo.svg') ?>
                                </a>
                            </li>
                            <li class="footer__icono-red">
                                <a href="https://www.instagram.com/unexcavzla" class="footer__enlace-icono">
                                    <?= colocar_svg('@imagenes/iconos/instagram_logo.svg') ?> 
                                </a>
                            </li>
                            <li class="footer__icono-red">
                                <a href="https://linktr.ee/Unexca_Website" class="footer__enlace-icono">
                                    <?= colocar_svg('@imagenes/iconos/telegram_logo.svg') ?>
                                </a>
                            </li>
                            <li class="footer__icono-red">
                                <a href="https://linktr.ee/unexca" class="footer__enlace-icono">
                                    <?= colocar_svg('@imagenes/iconos/whatsapp_logo.svg') ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </footer>
    <?php
}