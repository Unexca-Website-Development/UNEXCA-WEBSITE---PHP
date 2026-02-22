<?php
/**
 * Plantilla administrativa (layout base para el panel de control).
 *
 * Variables esperadas:
 *  - $head_data: Datos para <head>.
 *  - $data_menu_control: Array con las opciones del menú.
 *  - $vista: Ruta completa del contenido específico.
 */
?>

<!DOCTYPE html>
<html lang="ES">
    <?php head($head_data ?? []); ?>
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/componentes/menu_control.css') ?>">

    <body class="admin-body">
        <?php menu_control($data_menu_control ?? []); ?>
        <main class="admin-layout">
            <section class="admin-layout__contenido">
                <?php include $vista; ?>
            </section>
        </main>
    </body>
</html>
