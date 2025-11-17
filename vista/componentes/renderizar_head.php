<?php
/**
 * Renderiza las etiquetas del <head> correspondientes al título, metadatos
 * y hojas de estilo. Este componente no contiene lógica de negocio;
 * únicamente imprime contenido HTML seguro para la cabecera del documento.
 *
 * Parámetros:
 * @param array $data Arreglo asociativo con las claves opcionales:
 *   - 'title'  (string)  Título de la página.
 *   - 'meta'   (array)   Lista de metadatos en formato ['name' => 'content'].
 *   - 'styles' (array)   Lista de rutas relativas a hojas de estilo.
 *
 * Comportamiento:
 *  - Si no se envía 'title', usa "UNEXCA" por defecto.
 *  - Si 'meta' está vacío o no existe, no imprime metadatos.
 *  - Si 'styles' está vacío o no existe, no imprime hojas de estilo.
 *
 * Retorna:
 * @return void
 *
 * Uso:
 *  - El controlador prepara los valores del título, meta y estilos.
 *  - La vista principal (layout) invoca este componente dentro del <head>.
 */
function renderizar_head(array $data) {
    ?>
        <title><?= htmlspecialchars($data['title'] ?? 'UNEXCA') ?></title>

        <?php if (!empty($data['meta'])): ?>
            <?php foreach ($data['meta'] as $name => $content): ?>
                <meta name="<?= htmlspecialchars($name) ?>" content="<?= htmlspecialchars($content) ?>">
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($data['styles'])): ?>
            <?php foreach ($data['styles'] as $style): ?>
                <link rel="stylesheet" href="<?= colocar_ruta_html($style) ?>">
            <?php endforeach; ?>
        <?php endif; ?>
    <?php
}