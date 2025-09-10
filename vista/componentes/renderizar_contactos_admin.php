<?php
function renderizar_contactos_admin($data_array) {
    $campos = [
        'telefono' => 'Teléfono',
        'email' => 'Correo',
        'oficina' => 'Oficina'
    ];

    foreach ($data_array as $nucleo => $contacto){
        ?>
        <div class="contactos-admin__nucleo">
            <h3 class="contactos-admin__titulo-nucleo">Núcleo <?= htmlspecialchars($nucleo); ?></h3>
            <ul class="contactos-admin__lista">
                <?php foreach ($contacto as $c): ?>
                    <li class="contactos-admin__item">
                        <h4 class="contactos-admin__cargo"><?= htmlspecialchars($c['cargo']); ?></h4>
                        
                        <?php if (!empty($c['nombre']) || !empty($c['telefono']) || !empty($c['email']) || !empty($c['oficina'])): ?>
                            <div class="contactos-admin__informacion">
                                <?php if (!empty($c['nombre'])): ?>
                                    <div class="contactos-admin__nombre"><?= htmlspecialchars($c['nombre']); ?></div>
                                <?php endif; ?>

                                <?php foreach ($campos as $clave => $etiqueta): ?>
                                    <?php if (!empty($c[$clave])): ?>
                                        <span class="contactos-admin__detalle"><?= $etiqueta ?>: <?= htmlspecialchars($c[$clave]) ?></span>
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
