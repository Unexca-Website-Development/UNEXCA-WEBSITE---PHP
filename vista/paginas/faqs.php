<?php
/**
 * faqs.php
 *
 * Página de Preguntas Frecuentes (FAQs) de la universidad.
 *
 * Propósito:
 * Muestra una lista de preguntas frecuentes en formato de lista desplegable interactiva.
 *
 * Variables esperadas del controlador:
 * @var array $data_faqs Arreglo con las preguntas y respuestas a renderizar.
 *
 * Componentes utilizados:
 * - lista_desplegable(): Genera los elementos HTML de las preguntas y respuestas.
 *
 * Scripts incluidos:
 * - desplegables.js: Maneja la interacción de abrir/cerrar los desplegables.
 */
?>
<main class="main__general">
    <section class="seccion">
        <h2 class="titulos">Preguntas Frecuentes</h2>
        <div class="desplegables__contenedor">
            <?php lista_desplegable($data_faqs); ?>
        </div>
    </section>
</main>
<script src="<?= colocar_ruta_html('@scripts/desplegables.js')?>"></script>