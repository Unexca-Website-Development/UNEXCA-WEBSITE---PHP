<?php
/**
 * boton
 *
 * Genera un botón como enlace (<a>) con contenido, clases CSS y atributos HTML opcionales.
 *
 * Parámetros:
 * @param string $link URL del enlace. Por defecto '#'.
 * @param string $contenido Texto o HTML que se mostrará dentro del botón. Por defecto 'Más Información'.
 * @param string $clases Clases CSS que se aplicarán al botón. Por defecto 'boton-principal'.
 * @param array $atributos Arreglo asociativo de atributos HTML adicionales, por ejemplo ['target' => '_blank', 'id' => 'btn1'].
 *
 * Retorna:
 * Imprime directamente el HTML del enlace con los atributos y contenido especificado.
 */
function boton($link = '#', $contenido = 'Más Información', $clases = 'boton-principal', $atributos = []) {
    // Inyectar atributos de HTML
    $html_atributos = '';
    foreach ($atributos as $clave => $valor) {
        $html_atributos .= " $clave=\"" . htmlspecialchars($valor) . "\"";
    }

    ?>
        <a href="<?= htmlspecialchars($link) ?>" class="<?= htmlspecialchars($clases) ?>"<?= $html_atributos ?>>
            <?= $contenido ?>
            <?= colocar_svg('@imagenes/iconos/flecha.svg') ?>
        </a>
    <?php
}