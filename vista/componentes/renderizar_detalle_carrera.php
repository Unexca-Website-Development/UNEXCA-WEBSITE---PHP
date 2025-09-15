<?php
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