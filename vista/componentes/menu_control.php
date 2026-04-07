<?php
/**
 * menu_control
 *
 * Renderiza el menú lateral de control administrativo.
 * RF-01, RF-02, RF-03 del Menú de Control.
 *
 * @param array $data Lista de opciones del menú.
 */
function menu_control($data) {
    ?>
    <nav class="menu-control">
        <div class="menu-control__header">
            <h2 class="menu-control__titulo">Panel de Control</h2>
        </div>
        <ul class="menu-control__lista">
            <?php foreach ($data as $item): 
                $esta_activo = (isset($_GET['pagina']) && $_GET['pagina'] === $item['url']);
                $clase_activo = $esta_activo ? 'menu-control__enlace--activo' : '';
            ?>
                <li class="menu-control__item">
                    <a href="<?= $item['url'] ?>" 
                       class="menu-control__enlace <?= $clase_activo ?>"
                       aria-current="<?= $esta_activo ? 'page' : 'false' ?>">
                        <span class="menu-control__icono menu-control__icono--<?= $item['icon'] ?>"></span>
                        <span class="menu-control__texto"><?= htmlspecialchars($item['titulo']) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="menu-control__footer">
            <a href="<?= colocar_enlace('inicio') ?>" class="menu-control__volver">Volver al Sitio</a>
        </div>
    </nav>
    <?php
}
