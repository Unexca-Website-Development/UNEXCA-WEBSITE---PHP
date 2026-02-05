<!DOCTYPE html>
<html lang="ES">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/index.css')?>">
        <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/paginas/error.css')?>">
        <link rel="shortcut icon" href="<?= colocar_ruta_html('@imagenes/iconos/favicon.ico') ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= colocar_ruta_html('@imagenes/iconos/favicon-16x16.png') ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= colocar_ruta_html('@imagenes/iconos/favicon-32x32.png') ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= colocar_ruta_html('@imagenes/iconos/apple-touch-icon.png') ?>">
        <link rel="icon" type="image/png" sizes="192x192" href="<?= colocar_ruta_html('@imagenes/iconos/android-chrome-192x192.png') ?>">
        <link rel="icon" type="image/png" sizes="512x512" href="<?= colocar_ruta_html('@imagenes/iconos/android-chrome-512x512.png') ?>">
        <title>UNEXCA - 403</title>

    </head>
    <body>
        <div class="error">
            <a href="<?= colocar_enlace('inicio'); ?>" class="error_logo">
                <?= colocar_svg('@imagenes/logos/logo_menu.svg') ?>
            </a>
            <p class="error_texto">403</p>
        </div>
    </body>
</html>