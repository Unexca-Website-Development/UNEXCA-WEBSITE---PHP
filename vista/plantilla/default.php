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
        <?php head($head_data ?? []); ?>
    <body>
        <?php cabecera($data_header ?? []) ?>

        <div class="main__contenedor" id="main">
            <?php include $vista; ?>
        </div>

        <?php footer($data_footer ?? []) ?>
        
        <script src="<?= colocar_ruta_html('@scripts/header.js')?>"></script>
    </body>
</html>