<?php
/**
 * carrera.php
 *
 * Página de detalle de una carrera académica.
 *
 * Propósito:
 * Muestra la información detallada de una carrera, incluyendo descripción, turnos, ubicaciones, niveles, diplomas y enlace a la malla curricular.
 *
 * Variables esperadas del controlador:
 * @var array $data_carreras Arreglo con los datos de la carrera a mostrar. Debe contener:
 *   - 'titulo'
 *   - 'parrafos'
 *   - 'turnos'
 *   - 'nucleos'
 *   - 'niveles'
 *   - 'link_malla_curricular'
 *
 * Componentes utilizados:
 * - detalle_carrera(): Genera la sección de detalle de la carrera en HTML.
 */
?>
<main class="main__general">
    <?php detalle_carrera($data_carreras); ?>
</main>