<?php
/**
 * servicios.php
 *
 * Página institucional que muestra los servicios que ofrece la Universidad Nacional Experimental de la Gran Caracas (UNEXCA).
 *
 * Propósito:
 * Informar a los usuarios sobre los distintos servicios disponibles mediante una lista desplegable interactiva.
 *
 * Variables esperadas del controlador:
 * @var array $data_servicios Arreglo de servicios con los campos:
 *   - 'id': Identificador único del servicio.
 *   - 'titulo': Título del servicio.
 *   - 'contenido': Descripción o detalle del servicio.
 *
 * Componentes utilizados:
 * - renderizar_lista_desplegable(): genera los elementos desplegables interactivos.
 * - Script de funcionalidad: '@scripts/desplegables.js' para el comportamiento dinámico.
 */
?>

<main class="main__general">
    <section class="seccion">
        <h2 class="titulos">Servicios</h2>
        <div class="desplegables__contenedor">
            <?php renderizar_lista_desplegable($data_servicios); ?>
        </div>
    </section>
</main>
<script src="<?= colocar_ruta_html('@scripts/desplegables.js')?>"></script>