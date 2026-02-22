<main class="main-contenido">
    <section class="seccion-nucleos">
        <div class="contenedor">
            <h1 class="titulo-seccion" style="color: ;">Gestión de Núcleos</h1>
            
            <!-- Listado de Núcleos (RF-01) -->
            <div class="listado-nucleos-cabecera">
                <h2>Listado Actual</h2>
                <a href="<?= colocar_enlace('nucleos') ?>" class="btn-actualizar">🔄 Actualizar listado</a>
            </div>
            <div class="tabla-contenedor">
                <table class="tabla-nucleos">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data_nucleos)): ?>
                            <?php foreach ($data_nucleos as $nucleo): ?>
                                <tr>
                                    <td>
                                        <img src="<?= htmlspecialchars(procesar_enlace($nucleo['imagen'])) ?>" alt="Imagen de <?= htmlspecialchars($nucleo['nombre']) ?>" class="img-nucleo">
                                    </td>
                                    <td><?= htmlspecialchars($nucleo['nombre']) ?></td>
                                    <td>
                                        <?php
                                            $direccion = htmlspecialchars($nucleo['direccion'] ?? 'Sin dirección asignada');
                                            // Convertir URLs planas en enlaces clickeables (target _blank)
                                            $direccion_con_enlaces = preg_replace(
                                                '/(https?:\/\/[^\s]+)/',
                                                '<a href="$1" target="_blank" rel="noopener noreferrer" style="color: #007bff; text-decoration: underline;">$1</a>',
                                                $direccion
                                            );
                                            echo $direccion_con_enlaces;
                                        ?>
                                    </td>
                                    <td class="acciones">
                                        <button class="btn-editar" onclick="editarNucleo(<?= htmlspecialchars(json_encode($nucleo)) ?>)">✏️ Editar</button>
                                        <form action="<?= colocar_enlace('nucleos/eliminar') ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este núcleo?');" class="form-eliminar">
                                            <input type="hidden" name="id" value="<?= $nucleo['id'] ?>">
                                            <button type="submit" class="btn-eliminar">🗑️ Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay núcleos registrados en el sistema.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <hr class="separador">
            <!-- Formulario de Creación / Edición (RF-03 y RF-04) -->
            <div class="formulario-seccion" id="seccion-formulario">
                <h2 id="formulario-titulo">Registrar Nuevo Núcleo</h2>
                <form id="form-nucleos" action="<?= colocar_enlace('nucleos/guardar') ?>" method="POST" enctype="multipart/form-data" class="form-admin">
                    <input type="hidden" name="id" id="nucleo_id" value="">
                    
                    <div class="form-grupo">
                        <label for="nombre">Nombre del Núcleo <span class="requerido">*</span></label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Ej. Núcleo Caracas">
                    </div>
                    <div class="form-grupo">
                        <label for="direccion">Dirección Física <span class="requerido">*</span></label>
                        <textarea id="direccion" name="direccion" required placeholder="Ej. Av. Francisco de Miranda..."></textarea>
                    </div>
                    <div class="form-grupo">
                        <label for="imagen">Imagen Institucional (Opcional)</label>
                        <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg,.png,.webp">
                        <small class="hint">Si no seleccionas una imagen, se utilizará la imagen por defecto.</small>
                    </div>
                    <div class="form-acciones">
                        <button type="submit" class="btn-guardar" id="btn-guardar">💾 Guardar Registro</button>
                        <button type="button" class="btn-cancelar" id="btn-cancelar" onclick="cancelarEdicion()" style="display:none;">❌ Cancelar Edición</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<script>
    function editarNucleo(nucleo) {
        document.getElementById('formulario-titulo').innerText = 'Editar Núcleo';
        document.getElementById('form-nucleos').action = '<?= colocar_enlace('nucleos/actualizar') ?>';
        
        document.getElementById('nucleo_id').value = nucleo.id;
        document.getElementById('nombre').value = nucleo.nombre;
        document.getElementById('direccion').value = nucleo.direccion || '';
        
        document.getElementById('btn-guardar').innerHTML = '💾 Actualizar Registro';
        document.getElementById('btn-cancelar').style.display = 'inline-block';
        
        // Scroll hacia el formulario
        document.getElementById('seccion-formulario').scrollIntoView({ behavior: 'smooth' });
    }
    function cancelarEdicion() {
        document.getElementById('formulario-titulo').innerText = 'Registrar Nuevo Núcleo';
        document.getElementById('form-nucleos').action = '<?= colocar_enlace('nucleos/guardar') ?>';
        
        document.getElementById('form-nucleos').reset();
        document.getElementById('nucleo_id').value = '';
        
        document.getElementById('btn-guardar').innerHTML = '💾 Guardar Registro';
        document.getElementById('btn-cancelar').style.display = 'none';
        
        // Scroll hacia arriba
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>