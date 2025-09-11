<?php
function renderizar_contactos_admin($data_array) {
    $campos = [
        'telefono' => 'Teléfono',
        'email' => 'Correo',
        'oficina' => 'Oficina'
    ];

    foreach ($data_array as $nucleo => $contacto){
        ?>
        <div class="contactos__bloque">
            <h3 class="contactos__titulo-bloque">Núcleo <?= htmlspecialchars($nucleo); ?></h3>
            <ul class="contactos__lista">
                <?php foreach ($contacto as $c): ?>
                    <li class="contactos__item">
                        <h4 class="contactos__titulo-info"><?= htmlspecialchars($c['cargo']); ?></h4>
                        
                        <?php if (!empty($c['nombre']) || !empty($c['telefono']) || !empty($c['email']) || !empty($c['oficina'])): ?>
                            <div class="contactos__info">
                                <?php if (!empty($c['nombre'])): ?>
                                    <div class="contactos__nombre"><?= htmlspecialchars($c['nombre']); ?></div>
                                <?php endif; ?>

                                <?php foreach ($campos as $clave => $etiqueta): ?>
                                    <?php if (!empty($c[$clave])): ?>
                                        <span class="contactos__detalle"><span class="negrita"><?= $etiqueta ?>:</span> <?= htmlspecialchars($c[$clave]) ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}
