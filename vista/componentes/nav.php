<?php
// Esta es una data de prueba
    $data_ejemplo = [
        "La Unexca" => [
            "url" => "#",
            "submenu" => [
                "Historia" => "history.html",
                "Misión, Visión y Valores" => "history.html#mis-vi-va",
                "Autoridades Universitarias" => "autoridades.html",
            ],
        ],
        "Programas Académicos" => [
            "url" => "index.html#carr_link",
            "submenu" => [],
        ],
        "Noticias" => [
            "url" => "index.html#noti_link",
            "submenu" => [],
        ],
        "Acerca de..." => [
            "url" => "#",
            "submenu" => [
                "Servicios" => "servicios.html",
                "Contactos" => "contacto.html",
                "Preguntas Frecuentes" => "faqs.html",
            ],
        ],
    ];
?>

<?php
function renderizarMenu($data_ejemplo) {
    ?>
    <nav class="navbar">
        <ul class="menu">
            <?php 
                // Itera la data que resive
                foreach ($data_ejemplo as $nombre => $info):

                // Guarda true si no esta vacio el array y false si lo esta.
                // Ademas se asegura de que sea un array valido
                $tiene_sub_menu = !empty($info['submenu']) && is_array($info['submenu']);
            ?>
                <li class="menu-item <?= $tiene_sub_menu ? 'has-sub-menu' : '' ?>">
                    <a href="<?= htmlspecialchars($info['url'] ?? '#', ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($nombre ?? 'Enlace', ENT_QUOTES, 'UTF-8') ?>
                    </a>

                    <?php if ($tiene_sub_menu): ?>
                        <ul class="sub-menu">
                            <?php foreach ($info['submenu'] as $texto => $url): ?>
                                <li class="menu-item">
                                    <a href="<?= htmlspecialchars($url ?? '#', ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($texto ?? 'Default', ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <?php
}
?>
