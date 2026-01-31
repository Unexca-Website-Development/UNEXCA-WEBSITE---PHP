<?php

/**
 * contactos_coords
 *
 * Renderiza la lista de contactos de coordinadores académicos agrupados por carrera (PNF).
 *
 * Cada bloque muestra:
 *  - Nombre del PNF.
 *  - Lista de coordinadores con nombre completo, teléfono, correo, oficina y horario.
 *
 * Estructura esperada de $data_array:
 * [
 *     'Nombre del PNF' => [
 *         [
 *             'titulo_academico' => string,   // Ej: "Ing.", "Lcdo.", "MSc.", (opcional)
 *             'nombre' => string,             // Nombre completo del coordinador
 *             'telefono' => string,           // Número de teléfono
 *             'email' => string,              // Correo electrónico
 *             'oficina' => string,            // Oficina asignada
 *             'horario_atencion' => string,   // Horario de atención
 *         ],
 *         ...
 *     ],
 *     ...
 * ]
 *
 * Regla especial:
 * - Si un coordinador no tiene nombre + título académico válido, se omite del renderizado.
 *
 * @param array $data_array Arreglo de coordinadores agrupados por carrera.
 * @return void Este componente imprime directamente el HTML.
 */

function contactos_coords($data_array) {
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
