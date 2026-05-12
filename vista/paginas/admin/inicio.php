<section class="admin-section">
    <div class="admin-section__header">
        <h2 class="admin-section__title">Panel de Control</h2>
    </div>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'sin_permiso'): ?>
        <div class="admin-alert admin-alert--error" style="background: #fee2e2; color: #991b1b; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #f87171; display: flex; align-items: center; gap: 1rem;">
            <span style="font-size: 1.5rem;">🚫</span>
            <div>
                <strong style="display: block; margin-bottom: 0.25rem;">Acceso Denegado</strong>
                <p style="margin: 0; font-size: 0.9rem; opacity: 0.9;">No tienes los permisos necesarios para realizar esta acción. Si crees que esto es un error, contacta al administrador del sistema.</p>
            </div>
        </div>
    <?php endif; ?>

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
