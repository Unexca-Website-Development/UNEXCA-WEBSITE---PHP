<?php

/**
 * Renderiza el encabezado principal del sitio, incluyendo:
 *  - Botón de apertura del menú móvil.
 *  - Logotipo con enlace a la página de inicio.
 *  - Menú de navegación obtenido desde la base de datos.
 *  - Overlay para manejo visual del menú en pantallas pequeñas.
 *  - Decoración SVG inferior del header.
 *
 * Parámetros:
 * @param array $data_array Arreglo de navegación enviado por el controlador.
 *   Este arreglo es consumido por links_header(), que debe recibir
 *   una estructura ya validada por la capa de servicio.
 *
 * Comportamiento:
 *  - No aplica validaciones de negocio; solo imprime HTML.
 *  - Sanitiza el enlace del logo mediante colocar_enlace(), que depende
 *    del sistema de rutas del proyecto.
 *  - El menú se representa a través del componente links_header().
 *
 * Retorna:
 * @return void
 *
 * Uso:
 *  - Debe ser llamado desde la vista principal (layout) antes del contenido.
 *  - Requiere que el controlador haya obtenido previamente los enlaces del menú
 *    mediante el servicio correspondiente.
 */

function cabecera(array $data_array = []) {
    ?>
        <header class="header">
            <div class="header__contenedor">
                <div class="header__contenedor-nav">
                    <button class="header__boton-menu" aria-expanded="false" aria-controls="abrir menu">
                        <?= colocar_svg('@imagenes/iconos/icon_menu_open.svg') ?>
                    </button>

                    <a href="<?= colocar_enlace('inicio'); ?>" class="header__logo-menu">
                        <?= colocar_svg('@imagenes/logos/logo_menu.svg') ?>
                    </a> 
                    <?php links_header($data_array) ?>

                    <div class="overlay"></div>
                </div>
            </div>
            <?= colocar_svg('@imagenes/decorativos/decoracion.svg') ?>
        </header>
    <?php
}
