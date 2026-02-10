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
    <body class="admin-body">
        
        <?php menu_control($data_menu_control ?? [], $_GET['pagina'] ?? 'admin'); ?>

        <main class="admin-layout">
            <header class="admin-layout__header">
                <h1>Administración UNEXCA</h1>
                <hr>
            </header>

            <section class="admin-layout__contenido">
                <?php include $vista; ?>
            </section>
        </main>

    </body>
</html>
