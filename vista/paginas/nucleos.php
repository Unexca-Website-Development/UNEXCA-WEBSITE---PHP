<main class="main-contenido">
    <section class="seccion-nucleos">
        <div class="contenedor">
            <h1 class="titulo-seccion">Nuestros Núcleos</h1>
            
            <div class="listado-nucleos-cabecera">
                <h2>Listado de Núcleos y Extensiones</h2>
            </div>
            <div class="tabla-contenedor">
                <table class="tabla-nucleos">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data_nucleos)): ?>
                            <?php foreach ($data_nucleos as $nucleo): ?>
                                <tr>
                                    <td>
                                        <img src="<?= htmlspecialchars(procesar_enlace($nucleo['imagen'] ?? '')) ?>" alt="Imagen de <?= htmlspecialchars($nucleo['nombre']) ?>" class="img-nucleo">
                                    </td>
                                    <td><?= htmlspecialchars($nucleo['nombre']) ?></td>
                                    <td>
                                        <?php
                                            $direccion = htmlspecialchars($nucleo['direccion'] ?? 'Sin dirección asignada');
                                            $direccion_con_enlaces = preg_replace(
                                                '/(https?:\/\/[^\s]+)/',
                                                '<a href="$1" target="_blank" rel="noopener noreferrer" style="color: #007bff; text-decoration: underline;">$1</a>',
                                                $direccion
                                            );
                                            echo $direccion_con_enlaces;
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No hay núcleos registrados en el sistema.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>