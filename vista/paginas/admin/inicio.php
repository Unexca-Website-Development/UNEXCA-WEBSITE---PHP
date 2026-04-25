<section class="admin-section">
    <div class="admin-section__header">
        <h2 class="admin-section__title">Panel de Control</h2>
    </div>

    <div class="admin-dashboard">
        <p>Bienvenido al sistema de gestión de contenidos de la UNEXCA.</p>
        <div class="admin-dashboard__resumen" style="margin-top: 2rem; padding: 2rem; background: var(--bg-light); border-radius: 8px; text-align: center;">
            <p>Selecciona una opción en el menú lateral para comenzar a editar las secciones del portal.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; flex-wrap: wrap;">
                <a href="<?= colocar_enlace('admin-noticias') ?>" class="btn btn--primary">Gestionar Noticias</a>
                <a href="<?= colocar_enlace('admin-autoridades') ?>" class="btn btn--primary">Gestionar Autoridades</a>
                <a href="<?= colocar_enlace('admin-nucleos') ?>" class="btn btn--primary">Gestionar Núcleos</a>
            </div>
        </div>
    </div>
</section>
