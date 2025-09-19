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

    <?php renderizar_head($head_data ?? []); ?>
</head>
<body>
    <?php renderizar_header($data_header) ?>

    <div class="main__contenedor" id="main">
        <?php include $vista_plantilla; ?>
    </div>

    <?php renderizar_footer($data_footer) ?>
    
    <script src="<?= colocar_ruta_html('@scripts/header.js')?>"></script>
</body>
</html>