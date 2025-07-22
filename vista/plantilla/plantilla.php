<!DOCTYPE html>
<html lang="es">
<head>
    <?php include colocar_ruta_sistema("@componentes/head.php"); ?>
</head>
<body>
    <?php include colocar_ruta_sistema("@componentes/header.php"); ?>

    <main>
        <?php include $archivoVista; ?>
    </main>

    <?php include colocar_ruta_sistema("@componentes/footer.php"); ?>
</body>
</html>