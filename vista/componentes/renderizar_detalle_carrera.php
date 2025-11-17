<?php
/**
 * renderizar_detalle_carrera
 *
 * Renderiza la información detallada de una carrera académica, incluyendo descripción,
 * turnos, núcleos donde se imparte, niveles, duración y el enlace para descargar
 * la malla curricular.
 *
 * Estructura esperada de $data_array:
 * [
 *     'titulo' => string,                 // Nombre de la carrera
 *
 *     'parrafos' => [                     // Descripción de la carrera en párrafos
 *         [ 'contenido' => string ],
 *         ...
 *     ],
 *
 *     'turnos' => [                       // Lista de turnos disponibles
 *         string, string, ...
 *     ],
 *
 *     'nucleos' => [                      // Núcleos donde se imparte la carrera
 *         [ 'nombre' => string ],
 *         ...
 *     ],
 *
 *     'niveles' => [                      // Niveles académicos y su duración
 *         [
 *             'nivel'    => string,       // Ej: "TSU", "Ingeniería"
 *             'duracion' => string,       // Ej: "2 años"
 *             'diploma'  => string        // Nombre del diploma asociado
 *         ],
 *         ...
 *     ],
 *
 *     'link_malla_curricular' => string   // URL para descargar la malla curricular
 * ]
 *
 * Reglas especiales:
 * - Cualquier sección vacía simplemente no se renderiza.
 * - Los datos se imprimen directamente como HTML y se escapan para evitar inyección XSS.
 *
 * @param array $data_array Datos completos de la carrera.
 * @return void Este componente imprime directamente el HTML.
 */
function renderizar_detalle_carrera($data_array) {
    ?>
        <section class="detalle-carrera__seccion">
            <h2 class="titulos">
                <?= htmlspecialchars($data_array['titulo']) ?>
            </h2>

            <div class="detalle-carrera__contenedor">
                <div class="detalle-carrera__descripcion">
                    <?php if (!empty($data_array['parrafos'])): ?>
                        <?php foreach ($data_array['parrafos'] as $parrafo): ?>
                            <p class="detalle-carrera__parrafo"><?= htmlspecialchars($parrafo['contenido']) ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <ul class="detalle-carrera__lista">

                    <li class="detalle-carrera__item">
                        <div class="detalle-carrera__icono">
                            <?= colocar_svg('@imagenes/iconos/icon_duracion.svg') ?>
                        </div>
                        <ul class="detalle-carrera__sublista">
                            <?php if (!empty($data_array['turnos'])): ?>
                                <?php foreach ($data_array['turnos'] as $turno): ?>
                                    <li class="detalle-carrera__subitem"><?= htmlspecialchars($turno) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="detalle-carrera__item">
                        <div class="detalle-carrera__icono">
                            <?= colocar_svg('@imagenes/iconos/icon_ubicacion.svg') ?>
                        </div>
                        <ul class="detalle-carrera__sublista">
                            <?php if (!empty($data_array['nucleos'])): ?>
                                <?php foreach ($data_array['nucleos'] as $nucleo): ?>
                                    <li class="detalle-carrera__subitem"><?= htmlspecialchars($nucleo['nombre']) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="detalle-carrera__item">
                        <div class="detalle-carrera__icono">
                            <?= colocar_svg('@imagenes/iconos/icon_calendario.svg') ?>
                        </div>
                        <ul class="detalle-carrera__sublista">
                            <?php if (!empty($data_array['niveles'])): ?>
                                <?php foreach ($data_array['niveles'] as $nivel): ?>
                                    <li class="detalle-carrera__subitem"><?= htmlspecialchars($nivel['nivel']) ?>: <?= htmlspecialchars($nivel['duracion']) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="detalle-carrera__item">
                        <div class="detalle-carrera__icono">
                            <?= colocar_svg('@imagenes/iconos/icon_graduacion.svg') ?>
                        </div>
                        <ul class="detalle-carrera__sublista">
                            <?php if (!empty($data_array['niveles'])): ?>
                                <?php foreach ($data_array['niveles'] as $diploma): ?>
                                    <li class="detalle-carrera__subitem"><?= htmlspecialchars($diploma['diploma']) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="detalle-carrera__item">
                        <div class="detalle-carrera__icono">
                            <?= colocar_svg('@imagenes/iconos/icon_malla.svg') ?>
                        </div>
                        <a class="detalle-carrera__enlace" href="<?= htmlspecialchars($data_array['link_malla_curricular'] ?? '#', ENT_QUOTES, 'UTF-8') ?>">Descargar Malla Curricular</a>
                    </li>

                </ul>
            </div>

        </section>
    <?php
};