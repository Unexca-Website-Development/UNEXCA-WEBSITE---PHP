<main class="main__general">
    <section class="seccion">
        <h2 class="titulos">Contactos</h2>
        <div class="contactos-contenedor">
            <div class="contactos-admin">
                <?php renderizar_contactos_admin($data_contactos_admin); ?>
            </div>

            <div class="contactos-coords">
                <?php renderizar_contactos_coords($data_contactos_coords) ?>
            </div>
        </div>
    </section>
</main>