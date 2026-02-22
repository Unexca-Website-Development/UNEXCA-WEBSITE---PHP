<main class="main-contenido-admin">
    <div class="listado-admin-header">
        <h1 class="titulo-seccion">Gestión de Núcleos</h1>
    </div>

    <!-- Formulario de Creación / Edición -->
    <div class="formulario-seccion" id="seccion-formulario">
        <h2 id="formulario-titulo">Registrar Nuevo Núcleo</h2>
        <form id="form-nucleos" action="<?= colocar_enlace('admin-nucleos') ?>" method="POST" enctype="multipart/form-data" class="form-admin">
            <input type="hidden" name="accion" value="guardar">
            <input type="hidden" name="id" id="nucleo_id" value="">
            
            <div class="form-grupo">
                <label for="nombre">Nombre del Núcleo <span class="requerido">*</span></label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ej. Núcleo Caracas">
            </div>
            <div class="form-grupo">
                <label for="direccion">Dirección Física o URL de Google Maps <span class="requerido">*</span></label>
                <textarea id="direccion" name="direccion" required placeholder="Ej. Av. Francisco de Miranda... o https://maps.app.goo.gl/..." rows="3"></textarea>
            </div>
            <div class="form-grupo">
                <label for="imagen">Imagen Institucional (Opcional)</label>
                <input type="file" id="imagen" name="imagen" accept=".jpg,.jpeg,.png,.webp">
                <small class="hint">Si no seleccionas una imagen, se utilizará la imagen por defecto.</small>
            </div>
            <div class="form-acciones">
                <button type="submit" class="btn-guardar" id="btn-guardar">💾 Guardar</button>
                <button type="button" class="btn-cancelar" id="btn-cancelar" onclick="cancelarEdicion()" style="display:none;">❌ Cancelar</button>
            </div>
        </form>
    </div>
    
    <hr class="separador">

    <!-- Listado de Núcleos -->
    <div class="listado-admin-cabecera">
        <h2>Listado Actual</h2>
    </div>
    <div class="tabla-contenedor">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($nucleos)): ?>
                    <?php foreach ($nucleos as $nucleo): ?>
                        <tr>
                            <td>
                                <img src="<?= htmlspecialchars(procesar_enlace($nucleo['imagen'] ?? '')) ?>" alt="Imagen de <?= htmlspecialchars($nucleo['nombre']) ?>" class="img-listado-admin">
                            </td>
                            <td><?= htmlspecialchars($nucleo['nombre']) ?></td>
                            <td><?= htmlspecialchars($nucleo['direccion']) ?></td>
                            <td class="acciones">
                                <button class="btn-editar" onclick="editarNucleo(<?= htmlspecialchars(json_encode($nucleo)) ?>)">✏️ Editar</button>
                                <form action="<?= colocar_enlace('admin/nucleos') ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este núcleo?');" class="form-eliminar">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="id" value="<?= $nucleo['id'] ?>">
                                    <button type="submit" class="btn-eliminar">🗑️ Eliminar</button>
                                </form>
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
</main>
<script>
    function editarNucleo(nucleo) {
        document.getElementById('formulario-titulo').innerText = 'Editar Núcleo';
        
        const form = document.getElementById('form-nucleos');
        form.querySelector('input[name=id]').value = nucleo.id;
        form.querySelector('input[name=nombre]').value = nucleo.nombre;
        form.querySelector('textarea[name=direccion]').value = nucleo.direccion || '';
        
        document.getElementById('btn-guardar').innerText = '💾 Actualizar';
        document.getElementById('btn-cancelar').style.display = 'inline-block';
        
        document.getElementById('seccion-formulario').scrollIntoView({ behavior: 'smooth' });
    }

    function cancelarEdicion() {
        document.getElementById('formulario-titulo').innerText = 'Registrar Nuevo Núcleo';
        
        const form = document.getElementById('form-nucleos');
        form.reset();
        form.querySelector('input[name=id]').value = '';
        
        document.getElementById('btn-guardar').innerText = '💾 Guardar';
        document.getElementById('btn-cancelar').style.display = 'none';
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
