<?php
/**
 * contactos.php
 *
 * Página de contactos de la universidad.
 *
 * Propósito:
 * Muestra los contactos administrativos y de coordinación de PNF, organizados por núcleos y carreras.
 *
 * Variables esperadas del controlador:
 * @var array $data_contactos_admin Arreglo con los contactos administrativos por núcleo.
 * @var array $data_contactos_coords Arreglo con los contactos de coordinaciones por carrera.
 *
 * Componentes utilizados:
 * - renderizar_contactos_admin(): Genera los bloques de contactos administrativos.
 * - renderizar_contactos_coords(): Genera los bloques de contactos de coordinaciones.
 */
?>

<main class="main__general">
    <section class="seccion">
        <h2 class="titulos">Contactos</h2>
    </section>

    <section class="contactos-contenedor">
        <div class="contactos-admin">
            <?php renderizar_contactos_admin($data_contactos_admin); ?>
        </div>

        <div class="contactos-coords">
            <?php renderizar_contactos_coords($data_contactos_coords) ?>
        </div>
    </section>
</main>