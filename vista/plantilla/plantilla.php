<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php renderizar_head(); ?>
</head>
<body>
    <?php renderizar_header($data_header) ?>

    <div class="main__contenedor" id="main">
        <?php include $vista_plantilla; ?>
    </div>

    <?php renderizar_footer($data_footer) ?>
    
    <script src="<?= colocar_ruta_html('@scripts/headerScroll.js')?>"></script>
</body>
</html>