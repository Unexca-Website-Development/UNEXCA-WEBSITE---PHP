<?php
/**
 * Página de Autoridades
 *
 * Muestra información sobre las autoridades universitarias de la institución.
 *
 * Variables esperadas del controlador:
 * @var array $data_autoridades Arreglo de autoridades a mostrar. Cada elemento debe contener:
 *      - 'nombre'  => string Nombre completo de la autoridad
 *      - 'cargo'   => string Cargo o título de la autoridad
 *      - 'imagen'  => string Ruta relativa a la imagen de la autoridad
 *
 * Componentes utilizados:
 * - autoridades(): Componente que genera la lista de autoridades en HTML.
 *
 * Propósito:
 * Permitir al usuario conocer quiénes ocupan los cargos de dirección y gestión académica en la universidad.
 */
?>
<main class="main__general">
    <section class="seccion">
        <h2 class="titulos">Autoridades Universitarias</h2>
        <p class="parrafo">
            La Universidad está gobernada por un Consejo Universitario y dirigida por autoridades académicas y administrativas, entre ellas el Rector, los Vicerrectores y los Decanos. Estas autoridades trabajan en conjunto para asegurar el cumplimiento de la misión institucional, preservar los valores fundamentales y gestionar eficientemente las actividades académicas y administrativas de la Universidad.
        </p>
    </section>

    <section class="seccion">
        <?php autoridades($data_autoridades); ?>
    </section>
</main>