<?php 
// Esta es una data de prueba
    $data_ejemplo = [
        [
            "title" => "ejemplo y ejemplo",
            "links" => [
            "Historia" => "history.html",
            "Misión, Visión y Valores" => "history.html#mis-vi-va",
            "Autoridades Universitarias" => "autoridades.html",
            ],
        ],
        [
            "title" => "ejemplo y ejemplo",
            "links" => [
            "Historia" => "history.html",
            "Misión, Visión y Valores" => "history.html#mis-vi-va",
            "Autoridades Universitarias" => "autoridades.html",
            ],
        ],
        [
            "title" => "ejemplo y ejemplo",
            "links" => [
            "Historia" => "history.html",
            "Misión, Visión y Valores" => "history.html#mis-vi-va",
            "Autoridades Universitarias" => "autoridades.html",
            ],
        ],
    ];

function renderizar_links_footer($data_ejemplo) {
    ?>
    <div class="footer-links">
        <ul class="links-fila">
        <?php foreach ($data_ejemplo as $bloque): ?>
            <li class="links-columna">
                <p class="links-titulo"><?= htmlspecialchars($bloque['title']) ?></p>
                <ul class="links-lista">
                    <?php foreach ($bloque['links'] as $texto => $url): ?>
                        <li class="links-item">
                            <a href="<?= htmlspecialchars($url) ?>"><?= htmlspecialchars($texto) ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php
}