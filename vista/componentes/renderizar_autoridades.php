<?php
function renderizar_autoridades($data_array) {
    foreach ($data_array as $autoridad) {
        ?>
            <div class="autoridad">
                <div class="autoridad__imagen">
                    <img class="autoridad__img" src="<?= colocar_ruta_html("@imagenes/autoridades/") . htmlspecialchars(ltrim($autoridad['imagen'], '/')) ?>" alt="Imagen de <?= htmlspecialchars($autoridad['nombre']) ?>">
                </div>

                <div class="autoridad__texto">
                    <h3 class="autoridad__nombre"><?= htmlspecialchars($autoridad['nombre']) ?></h3>
                    <p class="autoridad__cargo"><?= htmlspecialchars($autoridad['cargo']) ?></p>
                </div>
            </div>
        <?php
    }
}