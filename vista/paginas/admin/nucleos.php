<section class="admin-section">
    <div class="admin-section__header">
        <h2 class="admin-section__title">Gestión de Núcleos</h2>
        <button class="btn btn--success" onclick="mostrarFormulario()">
            + Nuevo Núcleo
        </button>
    </div>

    <!-- Formulario de Creación / Edición -->
    <div id="formulario-nucleo" class="admin-form-card">
        <h3 id="formulario-titulo">Registrar Nuevo Núcleo</h3>
        <form action="<?= colocar_enlace('admin', ['seccion' => 'nucleos']) ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="accion" value="guardar">
            <input type="hidden" name="id" id="nucleo_id" value="">
            
            <div class="form-group">
                <label class="form-label" for="nombre">Nombre del Núcleo <span class="requerido">*</span></label>
                <input type="text" id="nombre" name="nombre" class="form-control" required placeholder="Ej. Núcleo Caracas">
            </div>
            
            <div class="form-group">
                <label class="form-label" for="direccion">Dirección Física o URL de Google Maps <span class="requerido">*</span></label>
                <textarea id="direccion" name="direccion" class="form-control" required placeholder="Ej. Av. Francisco de Miranda..." rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="imagen">Imagen Institucional (Opcional)</label>
                <input type="file" id="imagen" name="imagen" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                <p class="hint">Si no seleccionas una imagen, se utilizará la imagen por defecto.</p>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn--primary" id="btn-guardar">Guardar</button>
                <button type="button" class="btn btn--secondary" onclick="ocultarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>
    
    <!-- Listado de Núcleos -->
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="100">Imagen</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th width="150">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($nucleos)): ?>
                    <?php foreach ($nucleos as $nucleo): ?>
                        <tr>
                            <td>
                                <img src="<?= resolver_url_asset($nucleo['imagen']) ?>" alt="Imagen de <?= htmlspecialchars($nucleo['nombre']) ?>" class="img-thumbnail">
                            </td>
                            <td><?= htmlspecialchars($nucleo['nombre']) ?></td>
                            <td><?= htmlspecialchars($nucleo['direccion']) ?></td>
                            <td>
                                <div class="acciones">
                                    <button class="btn btn--primary btn--sm" onclick="editarNucleo(<?= htmlspecialchars(json_encode($nucleo)) ?>)">Editar</button>
                                    <form action="<?= colocar_enlace('admin', ['seccion' => 'nucleos']) ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este núcleo?');" style="display:inline">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?= $nucleo['id'] ?>">
                                        <button type="submit" class="btn btn--danger btn--sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No hay núcleos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    function mostrarFormulario() {
        document.getElementById('formulario-nucleo').classList.add('activo');
        document.getElementById('formulario-titulo').innerText = 'Registrar Nuevo Núcleo';
        document.getElementById('nucleo_id').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('btn-guardar').innerText = 'Guardar';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function ocultarFormulario() {
        document.getElementById('formulario-nucleo').classList.remove('activo');
    }

    function editarNucleo(nucleo) {
        mostrarFormulario();
        document.getElementById('formulario-titulo').innerText = 'Editar Núcleo';
        document.getElementById('nucleo_id').value = nucleo.id;
        document.getElementById('nombre').value = nucleo.nombre;
        document.getElementById('direccion').value = nucleo.direccion || '';
        document.getElementById('btn-guardar').innerText = 'Actualizar';
    }
</script>
