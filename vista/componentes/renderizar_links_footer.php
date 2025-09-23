<?php 
function renderizar_links_footer($data_array) {
    ?>
    <div class="footer__links">
        <ul class="footer__grupo-columnas">
            <?php foreach ($data_array as $titulo => $info): ?>
                <li class="footer__columna">
                    <p class="footer__titulo"><?= htmlspecialchars($titulo) ?></p>
                    <ul class="footer__lista">
                        <?php foreach ($info['submenu'] as $texto => $url): ?>
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