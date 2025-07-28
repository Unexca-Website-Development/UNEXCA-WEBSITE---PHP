<section class="banner">
    <h1 class="banner__titulo">UNEXCA</h1>
    <div class="banner__boton-contenedor">
        <?= colocar_svg('@imagenes/decoracion_2.svg'); ?>
        <a class="banner__boton-link" href="#inicio">
            Explora la Unexca
            <?= colocar_svg('@imagenes/flecha.svg'); ?>
        </a>
    </div>
    <div class="banner__imagen-contenedor">
        <img id="banner__imagen" class="activo" src="<?= colocar_ruta_html('@imagenes/banner_guaira.jpeg'); ?>">
    </div>
</section>

<main class="main__inicio">
    
    <section class="historia">
        <div class="historia__contenido">
            <h2 class="historia__titulo">Un poco de historia...</h2>
            <p class="historia__parrafo">
                Fundada el 27 de febrero de 2018, surge de la transformación del Colegio Universitario “Francisco de Miranda”, el Colegio Universitario “Profesor José Lorenzo Pérez Rodríguez” y el Colegio Universitario de Caracas, según el Decreto Presidencial N° 3.293 publicado en la Gaceta Oficial Extraordinaria N° 41.349, en el marco de la Misión Alma Mater.
            </p>
        </div>
        <?php renderizar_boton(); ?>
    </section>

    <section class="carreras">
        <div class="carreras__contenido">
            <h2 class="carreras__titulo">Oferta Académica</h2>
            <div class="carreras__lista">
                <?= renderizar_carreras($data_ejemplo_carrera); ?>
            </div>
            <div class="carreras__contenedor-botones">
                <div class="carreras__boton carreras__boton--izquierda">
                    <?= colocar_svg('@imagenes/flecha.svg'); ?>
                </div>
                <div class="carreras__boton carreras__boton--derecha">
                    <?= colocar_svg('@imagenes/flecha.svg'); ?>
                </div>
            </div>
        </div>
    </section>

    <section class="noticias">
        <div class="noticias__contenido">
            <h2 class="noticias__titulo">Noticias</h2>
            <div class="noticias__lista">
                <?= renderizar_noticias($data_ejemplo_noticias); ?>
            </div>
        </div>
    </section>

    <script src="<?= colocar_ruta_html('@scripts/slider.js')?>"> </script>
    <script src="<?= colocar_ruta_html('@scripts/headerScroll.js')?>"> </script>
</main>