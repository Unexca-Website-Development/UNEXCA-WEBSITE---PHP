<!DOCTYPE html>
<html lang="ES">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/index.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/paginas/general.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/componentes/footer.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/componentes/header.css')?>">
    <?php renderizar_head($head_data ?? []); ?>
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