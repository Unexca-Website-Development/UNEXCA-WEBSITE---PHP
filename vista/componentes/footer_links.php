<?php 
// Esta es una data de prueba
    $data_ejemplo_footer = [
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

function renderizar_links_footer($data_ejemplo_footer) {
    ?>
    <div class="footer__links">
        <ul class="footer__grupo-columnas">
            <?php foreach ($data_ejemplo_footer as $bloque): ?>
                <li class="footer__columna">
                    <p class="footer__titulo"><?= htmlspecialchars($bloque['title']) ?></p>
                    <ul class="footer__lista">
                        <?php foreach ($bloque['links'] as $texto => $url): ?>
                            <li class="footer__item">
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