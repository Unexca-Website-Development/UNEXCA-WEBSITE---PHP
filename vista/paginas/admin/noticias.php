<section class="admin-section">
    <div class="admin-section__header">
        <h2 class="admin-section__title">Gestión de Noticias</h2>
    </div>

    <div id="editor-principal"></div>
</section>

<?php if (isset($noticiaData) && $noticiaData): ?>
    <script>
        window.noticiaData = <?= json_encode($noticiaData) ?>;
    </script>
<?php endif; ?>

<script type="module" src="<?= colocar_ruta_html('@scripts/EditorNoticias/main.js')?>"></script>
