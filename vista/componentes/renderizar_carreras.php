<?php
function renderizar_carreras($data_array) {
    foreach ($data_array as $carrera) {
        ?>
        <div class="carrera">
            <div class="carrera__imagen">
                <img src="<?= colocar_ruta_html("@imagenes/carreras/") . htmlspecialchars(ltrim($carrera['img'], '/')) ?>" alt="<?= htmlspecialchars($carrera['title']) ?>">
            </div>
            <div class="carrera__contenido">
                <div class="carrera__contenedor-texto">
                    <h3 class="carrera__titulo">
                        <?= htmlspecialchars($carrera['title']) ?>
                    </h3>
                    <p class="carrera__descripcion">
                        <?= htmlspecialchars($carrera['descripcion']) ?>
                    </p>
                </div>
                <a class="carrera__enlace" href="<?= htmlspecialchars($carrera['links']) ?>">
                    Más Información
                    <?= colocar_svg('@imagenes/iconos/flecha.svg'); ?>
                </a>
            </div>
        </div>
        <?php
    }
}