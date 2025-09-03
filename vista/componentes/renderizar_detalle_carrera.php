<?php
function renderizar_detalle_carrera($data_array) {
    ?>
        <h2 class="titulos">
            <?= htmlspecialchars($data_array['titulo'])?>
        </h2>

        <section>
            <div>
                <?php if (!empty($data_array['parrafos'])): ?>
                    <?php foreach ($data_array['parrafos'] as $parrafo): ?>
                        <p><?= htmlspecialchars($parrafo['contenido']) ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div>
                <ul>
                    <li>
                        <?= colocar_svg('@imagenes/iconos/icon_duracion.svg') ?>
                        <ul>
                            <?php if (!empty($data_array['turnos'])): ?>
                                <?php foreach ($data_array['turnos'] as $turnos): ?>
                                    <li><?= htmlspecialchars($turnos['turno']) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li>
                        <?= colocar_svg('@imagenes/iconos/icon_ubicacion.svg') ?>
                        <ul>
                            <?php if (!empty($data_array['nucleos'])): ?>
                                <?php foreach ($data_array['nucleos'] as $nucleos): ?>
                                    <li><?= htmlspecialchars($nucleos['nombre']) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li>
                        <?= colocar_svg('@imagenes/iconos/icon_calendario.svg') ?>
                        <ul>
                            <?php if (!empty($data_array['niveles'])): ?>
                                <?php foreach ($data_array['niveles'] as $duracion): ?>
                                    <li><?= htmlspecialchars($duracion['nivel']) ?>: <?= htmlspecialchars($duracion['duracion']) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                   <li>
                        <?= colocar_svg('@imagenes/iconos/icon_graduacion.svg') ?>
                        <ul>
                            <?php if (!empty($data_array['niveles'])): ?>
                                <?php foreach ($data_array['niveles'] as $diplomas): ?>
                                    <li><?= htmlspecialchars($diplomas['diploma']) ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                   <li>
                        <?= colocar_svg('@imagenes/iconos/icon_malla.svg') ?>
                        <a href="<?= htmlspecialchars($data_array['link_malla_curricular'] ?? '#', ENT_QUOTES, 'UTF-8')?>">Descargar Malla Curricular</a>
                    </li>

                </ul>
            </div>
        </section>
    <?php
};