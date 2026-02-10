<div class="admin-autoridades">
    
    <div class="admin-autoridades__header">
        <h2>Listado de Autoridades</h2>
        <button class="boton-accion boton-nuevo" onclick="mostrarFormulario()">
            + Nueva Autoridad
        </button>
    </div>

    <!-- Formulario de Creación/Edición -->
    <div id="formulario-autoridad" class="formulario-admin">
        <h3 id="titulo-formulario">Registrar Autoridad</h3>
        <form action="<?= colocar_enlace('admin/autoridades') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="accion" value="guardar">
            <input type="hidden" name="id" id="campo-id">

            <div class="form-grupo">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="form-grupo">
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo" class="form-control" required>
            </div>

            <div class="form-grupo">
                <label for="imagen">Foto Institucional:</label>
                <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
                <p class="nota">Dejar vacío para mantener la imagen actual (al editar).</p>
            </div>

            <div class="acciones-form">
                <button type="submit" class="boton-accion boton-nuevo">Guardar</button>
                <button type="button" class="boton-accion" style="background:#95a5a6" onclick="ocultarFormulario()">Cancelar</button>
            </div>
        </form>
    </div>

    <!-- Tabla de Listado -->
    <table class="tabla-admin">
        <thead>
            <tr>
                <th width="50">Orden</th>
                <th width="80">Foto</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th width="150">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($autoridades)): ?>
                <tr>
                    <td colspan="5" style="text-align:center">No hay autoridades registradas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($autoridades as $index => $aut): ?>
                    <tr>
                        <td class="acciones-orden">
                            <?php if ($index > 0): ?>
                                <form action="<?= colocar_enlace('admin/autoridades') ?>" method="POST">
                                    <input type="hidden" name="accion" value="subir">
                                    <input type="hidden" name="id" value="<?= $aut['id'] ?>">
                                    <button type="submit" class="btn-orden" title="Subir">&uarr;</button>
                                </form>
                            <?php endif; ?>
                            
                            <?php if ($index < count($autoridades) - 1): ?>
                                <form action="<?= colocar_enlace('admin/autoridades') ?>" method="POST">
                                    <input type="hidden" name="accion" value="bajar">
                                    <input type="hidden" name="id" value="<?= $aut['id'] ?>">
                                    <button type="submit" class="btn-orden" title="Bajar">&darr;</button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <img src="<?= colocar_ruta_html('@imagenes/' . $aut['imagen']) ?>" 
                                 class="img-miniatura" alt="Foto">
                        </td>
                        <td><?= htmlspecialchars($aut['nombre']) ?></td>
                        <td><?= htmlspecialchars($aut['cargo']) ?></td>
                        <td class="acciones-fila">
                            <button class="btn-editar" 
                                onclick='editarAutoridad(<?= json_encode($aut) ?>)'>
                                Editar
                            </button>
                            
                            <form action="<?= colocar_enlace('admin/autoridades') ?>" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar a esta autoridad?');">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= $aut['id'] ?>">
                                <button type="submit" class="btn-eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function mostrarFormulario() {
        document.getElementById('formulario-autoridad').classList.add('activo');
        document.getElementById('titulo-formulario').textContent = 'Registrar Autoridad';
        document.getElementById('campo-id').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('cargo').value = '';
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
        // La imagen no se puede pre-llenar en un input file por seguridad
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
