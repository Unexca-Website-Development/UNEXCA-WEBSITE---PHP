<?php 
function renderizar_links_footer($data_array) {
    ?>
    <div class="footer__links">
        <ul class="footer__grupo-columnas">
            <?php foreach ($data_array as $bloque): ?>
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