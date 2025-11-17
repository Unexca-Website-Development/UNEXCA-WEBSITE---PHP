<?php
/**
 * renderizar_carreras
 *
 * Renderiza una lista de carreras académicas en formato de tarjetas.
 *
 * Cada tarjeta incluye:
 *  - Imagen de la carrera.
 *  - Título de la carrera.
 *  - Descripción breve.
 *  - Enlace de "Más Información" con icono.
 *
 * Estructura esperada de $data_array:
 * [
 *     [
 *         'img' => string,        // URL relativa de la imagen de la carrera
 *         'titulo' => string,     // Título de la carrera
 *         'descripcion' => string,// Descripción breve de la carrera
 *         'links' => string,      // URL del enlace de "Más Información"
 *     ],
 *     ...
 * ]
 *
 * @param array $data_array Arreglo de carreras a renderizar.
 * @return void Este componente imprime directamente el HTML.
 */
function renderizar_carreras($data_array) {
    foreach ($data_array as $carrera) {
        ?>
        <div class="carrera">
            <div class="carrera__imagen">
                <img src="<?= colocar_ruta_html("@imagenes/carreras/") . htmlspecialchars(ltrim($carrera['img'], '/')) ?>" alt="<?= htmlspecialchars($carrera['titulo']) ?>">
            </div>
            <div class="carrera__contenido">
                <div class="carrera__contenedor-texto">
                    <h3 class="carrera__titulo">
                        <?= htmlspecialchars($carrera['titulo']) ?>
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