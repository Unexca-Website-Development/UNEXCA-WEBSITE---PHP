<?php
/**
 * Componente: nucleos
 * 
 * Renderiza una sección con la información de los núcleos/sedes.
 * 
 * @param array $data_nucleos Arreglo de núcleos con 'nombre', 'imagen' y 'direccion'.
 */
function nucleos(array $data_nucleos): void {
    if (empty($data_nucleos)) {
        return;
    }
    ?>
    <div class="componente-nucleos">
        <div class="componente-nucleos__grid">
            <?php foreach ($data_nucleos as $nucleo): ?>
                <div class="nucleo-card">
                    <div class="nucleo-card__imagen-contenedor">
                        <img src="<?= resolver_url_asset($nucleo['imagen']) ?>" 
                             alt="Sede <?= htmlspecialchars($nucleo['nombre']) ?>" 
                             class="nucleo-card__img">
                    </div>
                    <div class="nucleo-card__contenido">
                        <h3 class="nucleo-card__nombre"><?= htmlspecialchars($nucleo['nombre']) ?></h3>
                        <p class="nucleo-card__direccion">
                            <?php
                                $direccion = htmlspecialchars($nucleo['direccion'] ?? 'Sin dirección asignada');
                                $direccion_con_enlaces = preg_replace(
                                    '/(https?:\/\/[^\s]+)/',
                                    '<a href="$1" target="_blank" rel="noopener noreferrer">$1</a>',
                                    $direccion
                                );
                                echo $direccion_con_enlaces;
                            ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
?>