<section class="admin-section">
    <div class="admin-section__header">
        <h2 class="admin-section__title">Gestión de Autoridades</h2>
        <button class="btn btn--success" onclick="mostrarFormulario()">
            + Nueva Autoridad
        </button>
    </div>

    <!-- Formulario de Creación/Edición -->
    <div id="formulario-autoridad" class="admin-form-card">
        <h3 id="titulo-formulario">Registrar Autoridad</h3>
        <form action="<?= colocar_enlace('admin-autoridades') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="accion" value="guardar">
            <input type="hidden" name="id" id="campo-id">

            <div class="form-group">
                <label class="form-label" for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="imagen">Foto Institucional:</label>
                <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
                <p class="hint">Dejar vacío para mantener la imagen actual (al editar).</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn--primary">Guardar</button>
                <button type="button" class="btn btn--secondary" onclick="ocultarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>

    <!-- Tabla de Listado -->
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th width="80">Orden</th>
                    <th width="100">Foto</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th width="150">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!isset($autoridades) || count($autoridades) === 0): ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay autoridades registradas.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($autoridades as $index => $aut): ?>
                        <tr>
                            <td>
                                <div class="order-controls">
                                    <?php if ($index > 0): ?>
                                        <form action="<?= colocar_enlace('admin-autoridades') ?>" method="POST">
                                            <input type="hidden" name="accion" value="subir">
                                            <input type="hidden" name="id" value="<?= $aut['id'] ?>">
                                            <button type="submit" class="btn-order" title="Subir">&uarr;</button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <?php if ($index < count($autoridades) - 1): ?>
                                        <form action="<?= colocar_enlace('admin-autoridades') ?>" method="POST">
                                            <input type="hidden" name="accion" value="bajar">
                                            <input type="hidden" name="id" value="<?= $aut['id'] ?>">
                                            <button type="submit" class="btn-order" title="Bajar">&darr;</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <img src="<?= resolver_url_asset($aut['imagen']) ?>" class="img-thumbnail" alt="Foto">
                            </td>
                            <td><?= htmlspecialchars($aut['nombre']) ?></td>
                            <td><?= htmlspecialchars($aut['cargo']) ?></td>
                            <td>
                                <div class="acciones">
                                    <button class="btn btn--primary btn--sm" 
                                        onclick='editarAutoridad(<?= json_encode($aut) ?>)'>
                                        Editar
                                    </button>
                                    
                                    <form action="<?= colocar_enlace('admin-autoridades') ?>" method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de eliminar a esta autoridad?');" style="display:inline">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?= $aut['id'] ?>">
                                        <button type="submit" class="btn btn--danger btn--sm">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    function mostrarFormulario() {
        document.getElementById('formulario-autoridad').classList.add('activo');
        document.getElementById('titulo-formulario').textContent = 'Registrar Autoridad';
        document.getElementById('campo-id').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('cargo').value = '';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function ocultarFormulario() {
        document.getElementById('formulario-autoridad').classList.remove('activo');
    }

    function editarAutoridad(datos) {
        mostrarFormulario();
        document.getElementById('titulo-formulario').textContent = 'Editar Autoridad';
        document.getElementById('campo-id').value = datos.id;
        document.getElementById('nombre').value = datos.nombre;
        document.getElementById('cargo').value = datos.cargo;
    }
</script>
