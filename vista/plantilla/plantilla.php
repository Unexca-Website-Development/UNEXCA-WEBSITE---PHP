<!DOCTYPE html>
<html lang="es">
<head>
    <?php renderizar_head(); ?>
</head>
<body>
    <?php renderizar_header($data_header) ?>

    <div class="main__contenedor">
        <?php include $archivoVista; ?>
    </div>

    <?php renderizar_footer($data_footer) ?>
</body>
</html>