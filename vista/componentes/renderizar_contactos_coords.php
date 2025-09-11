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
        <div class="contactos__bloque">
            <h3 class="contactos__titulo-bloque">Coordinación de PNF <?= htmlspecialchars($carrera); ?></h3>
            <ul class="contactos__lista">
                <?php foreach ($contactos as $c): ?>
                    <?php
                        $nombreCompleto = trim(
                            (!empty($c['titulo_academico']) ? $c['titulo_academico'] . ' ' : '') .
                            ($c['nombre'] ?? '')
                        );
                        if (empty($nombreCompleto)) continue;
                    ?>
                    <li class="contactos__item">
                        <h4 class="contactos__titulo-info"><?= htmlspecialchars($nombreCompleto) ?></h4>
                        <ul class="contactos__info">
                            <?php foreach ($campos as $clave => $etiqueta): ?>
                                <?php if (!empty($c[$clave])): ?>
                                    <li class="contactos__detalle"><span class="negrita"><?= $etiqueta ?>:</span> <?= htmlspecialchars($c[$clave]) ?></li>
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
