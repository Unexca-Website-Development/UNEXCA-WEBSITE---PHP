<?php
/**
 * renderizar_contactos_admin
 *
 * Renderiza la lista de contactos administrativos agrupados por núcleo.
 *
 * Cada bloque muestra:
 *  - Nombre del núcleo.
 *  - Lista de contactos con cargo, nombre, teléfono, correo y oficina.
 *
 * Estructura esperada de $data_array:
 * [
 *     'Nombre del Núcleo' => [
 *         [
 *             'id' => int,             // ID del contacto (opcional)
 *             'nombre' => string,      // Nombre completo del contacto
 *             'cargo' => string,       // Cargo del contacto
 *             'telefono' => string,    // Número de teléfono
 *             'email' => string,       // Correo electrónico
 *             'oficina' => string,     // Ubicación de la oficina
 *         ],
 *         ...
 *     ],
 *     ...
 * ]
 *
 * @param array $data_array Arreglo de contactos administrativos agrupados por núcleo.
 * @return void Este componente imprime directamente el HTML.
 */
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