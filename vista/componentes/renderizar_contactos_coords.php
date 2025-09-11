<?php
function renderizar_contactos_coords($data_array) {
    $campos = [
        'telefono'         => 'Teléfono',
        'email'            => 'Correo',
        'oficina'          => 'Oficina',
        'horario_atencion' => 'Horario'
    ];

    foreach ($data_array as $carrera => $contactos) {
        ?>
        <div class="contactos-coords__carrera">
            <h3 class="contactos-coords__titulo-carrera">Coordinación de PNF <?= htmlspecialchars($carrera); ?></h3>
            <ul class="contactos-coords__lista">
                <?php foreach ($contactos as $c): ?>
                    <?php
                        $nombreCompleto = trim(
                            (!empty($c['titulo_academico']) ? $c['titulo_academico'] . ' ' : '') .
                            ($c['nombre'] ?? '')
                        );
                        if (empty($nombreCompleto)) continue;
                    ?>
                    <li class="contactos-coords__detalles">
                        <h4 class="contactos-coords__titulo-informacion"><?= htmlspecialchars($nombreCompleto) ?></h4>
                        <ul class="contactos-coords__informacion">
                            <?php foreach ($campos as $clave => $etiqueta): ?>
                                <?php if (!empty($c[$clave])): ?>
                                    <li class="contactos-coords__detalle"><span class="negrita"><?= $etiqueta ?>:</span> <?= htmlspecialchars($c[$clave]) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}
