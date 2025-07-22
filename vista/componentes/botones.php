<?php 
function renderizar_boton($link = '#', $contenido = 'Más Información', $clases = 'boton-principal', $atributos = []) {
    // Inyectar atributos de HTML
    $html_atributos = '';
    foreach ($atributos as $clave => $valor) {
        $html_atributos .= " $clave=\"" . htmlspecialchars($valor) . "\"";
    }

    ?>
        <a href="<?= htmlspecialchars($link) ?>" class="<?= htmlspecialchars($clases) ?>"<?= $html_atributos ?>>
            <?= $contenido ?>
            <?= colocar_svg('@imagenes/flecha.svg') ?>
        </a>
    <?php
}