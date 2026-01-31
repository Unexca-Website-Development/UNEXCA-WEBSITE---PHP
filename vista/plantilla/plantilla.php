<?php
/**
 * Plantilla principal de la aplicación (layout base).
 *
 * Variables esperadas:
 *  - $head_data: Array con información para <head> (título, meta, estilos). Ejemplo:
 *        [
 *            "title" => "Título de la página",
 *            "styles" => ["@estilos/archivo.css"],
 *            "meta" => ["description" => "", "keywords" => ""]
 *        ]
 *  - $data_header: Array con datos necesarios para renderizar el header.
 *  - $data_footer: Array con datos necesarios para renderizar el footer.
 *  - $vista_plantilla: Ruta completa del contenido específico de la página.
 *
 * Funciones utilizadas:
 *  - head(array $head_data)
 *  - cabecera(array $data_header)
 *  - footer(array $data_footer)
 *  - colocar_ruta_html(string $ruta_alias)
 *
 * Descripción:
 *  Esta plantilla se encarga de renderizar la estructura general de todas las páginas,
 *  incluyendo el head, header, contenido dinámico y footer.
 */
?>

<!DOCTYPE html>
<html lang="ES">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/index.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/paginas/general.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/componentes/footer.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/componentes/header.css')?>">

    <!-- Iconos de las paginas -->
    <link rel="shortcut icon" href="<?= colocar_ruta_html('@imagenes/iconos/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= colocar_ruta_html('@imagenes/iconos/favicon-16x16.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= colocar_ruta_html('@imagenes/iconos/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= colocar_ruta_html('@imagenes/iconos/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= colocar_ruta_html('@imagenes/iconos/android-chrome-192x192.png') ?>">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= colocar_ruta_html('@imagenes/iconos/android-chrome-512x512.png') ?>">

    <?php head($head_data ?? []); ?>
</head>
<body>
    <?php cabecera($data_header) ?>

    <div class="main__contenedor" id="main">
        <?php include $vista; ?>
    </div>

    <?php footer($data_footer) ?>
    
    <script src="<?= colocar_ruta_html('@scripts/header.js')?>"></script>
</body>
</html>