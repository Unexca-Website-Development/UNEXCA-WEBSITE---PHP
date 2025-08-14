<main class="main__general">
    <section class="seccion">
        <h2 class="titulos">Servicios</h2>
        <div class="desplegables__contenedor">
            <?php renderizar_lista_desplegable($data_servicios); ?>
        </div>
    </section>
</main>
<script src="<?= colocar_ruta_html('@scripts/desplegables.js')?>"></script>