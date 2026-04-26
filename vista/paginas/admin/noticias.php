<section class="admin-section">
    <div class="admin-section__header">
        <h2 class="admin-section__title">Gestión de Noticias</h2>
        <?php if (!$modoEditor): ?>
            <a href="<?= colocar_enlace('admin-noticias', ['nueva' => 1]) ?>" class="btn btn--success">
                + Nueva Noticia
            </a>
        <?php else: ?>
            <a href="<?= colocar_enlace('admin-noticias') ?>" class="btn btn--secondary">
                Volver al Listado
            </a>
        <?php endif; ?>
    </div>

    <?php if (!$modoEditor): ?>
        <!-- Listado de Noticias -->
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="100">Imagen</th>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Fecha Pub.</th>
                        <th width="150">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listaNoticias)): ?>
                        <?php foreach ($listaNoticias as $noticia): ?>
                            <tr>
                                <td>
                                    <img src="<?= resolver_url_asset($noticia['imagen_principal']) ?>" alt="Miniatura" class="img-thumbnail" style="width: 80px; height: 50px; object-fit: cover;">
                                </td>
                                <td><?= htmlspecialchars($noticia['titulo_principal']) ?></td>
                                <td>
                                    <span class="badge badge--<?= $noticia['estado'] === 'publicado' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($noticia['estado']) ?>
                                    </span>
                                </td>
                                <td><?= $noticia['fecha_publicacion'] ? date('d/m/Y', strtotime($noticia['fecha_publicacion'])) : 'No pub.' ?></td>
                                <td>
                                    <div class="acciones">
                                        <a href="<?= colocar_enlace('admin-noticias', ['id' => $noticia['noticia_id']]) ?>" class="btn btn--primary btn--sm">Editar</a>
                                        <form action="<?= colocar_enlace('admin-noticias-eliminar') ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta noticia?');" style="display:inline">
                                            <input type="hidden" name="id" value="<?= $noticia['noticia_id'] ?>">
                                            <button type="submit" class="btn btn--danger btn--sm">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay noticias registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <!-- Editor de Noticias -->
        <div id="editor-principal"></div>

        <?php if (isset($noticiaData) && $noticiaData): ?>
            <script>
                window.noticiaData = <?= json_encode($noticiaData) ?>;
                
                // Parche para asegurar que los datos se vean
                window.addEventListener('load', () => {
                    setTimeout(() => {
                        const inputs = document.querySelectorAll('.editor-noticia textarea, .editor-noticia input');
                        if (inputs.length > 0 && inputs[0].value === '') {
                             console.log('Detectados campos vacíos, re-sincronizando...');
                             location.reload(true); // Forzar recarga total si falla
                        }
                    }, 1000);
                });
            </script>
        <?php endif; ?>

        <script type="module" src="<?= colocar_ruta_html('@scripts/EditorNoticias/main.js')?>?v=<?= time() ?>"></script>
    <?php endif; ?>
</section>
