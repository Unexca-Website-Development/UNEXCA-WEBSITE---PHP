<?php
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