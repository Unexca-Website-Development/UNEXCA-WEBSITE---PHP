<?php
    require_once __DIR__ . '/../../funciones.php';
?>

<!DOCTYPE html>
<html lang="ES">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/index.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/footer.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/header.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/inicio.css')?>">
    <title>UNEXCA - Inicio</title>
</head>
<body>
    <?php include colocar_ruta_sistema("@componentes/header.php"); ?>
    <section class="seccion-hero">
        <div class="seccion-hero__contenido">
            <h2 class="seccion-hero__titulo">Un poco de historia...</h2>
            <p class="seccion-hero__parrafo">
                Fundada el 27 de febrero de 2018, surge de la transformación del Colegio Universitario “Francisco de Miranda”, el Colegio Universitario “Profesor José Lorenzo Pérez Rodríguez” y el Colegio Universitario de Caracas, según el Decreto Presidencial N° 3.293 publicado en la Gaceta Oficial Extraordinaria N° 41.349, en el marco de la Misión Alma Mater.
            </p>
        </div>
    </section>

    <section class="seccion-hero">
        <div class="seccion-hero__contenido">
            <h2 class="seccion-hero__titulo">Un poco de historia...</h2>
            <p class="seccion-hero__parrafo">
                Fundada el 27 de febrero de 2018, surge de la transformación del Colegio Universitario “Francisco de Miranda”, el Colegio Universitario “Profesor José Lorenzo Pérez Rodríguez” y el Colegio Universitario de Caracas, según el Decreto Presidencial N° 3.293 publicado en la Gaceta Oficial Extraordinaria N° 41.349, en el marco de la Misión Alma Mater.
            </p>
        </div>
    </section>
    <?php include colocar_ruta_sistema("@componentes/footer.php") ?>
</body>
</html>