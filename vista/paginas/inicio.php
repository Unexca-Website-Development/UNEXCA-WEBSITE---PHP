<?php
/**
 * inicio.php
 *
 * Página de inicio de la Universidad Nacional Experimental de la Gran Caracas (UNEXCA).
 *
 * Propósito:
 * Presentar el banner principal, historia resumida de la universidad y los programas académicos disponibles.
 *
 * Variables esperadas del controlador:
 * @var array $data_carrera Arreglo con la información de las carreras académicas para renderizar.
 *
 * Componentes utilizados:
 * - Banner principal con imagen y botón de navegación.
 * - Sección de historia con contenido resumido y botón para ver más.
 * - Sección de carreras académicas que llama a carreras().
 * - Scripts: slider.js para navegación de carrusel de carreras.
 */
?>
<section class="banner">
    <h1 class="banner__titulo">UNEXCA</h1>
    <div class="banner__boton-contenedor">
        <?= colocar_svg('@imagenes/decorativos/decoracion_2.svg'); ?>
        <a class="banner__boton-link" href="#main__inicio">
            Explora la Unexca
            <?= colocar_svg('@imagenes/iconos/flecha.svg'); ?>
        </a>
    </div>
    <div class="banner__imagen-contenedor">
        <img id="banner__imagen" class="activo" src="<?= colocar_ruta_html('@imagenes/nucleos/urbina.jpg'); ?>">
    </div>
</section>

<main class="main__inicio" id="main__inicio">
    
    <section class="historia">
        <div class="historia__contenido">
            <h2 class="historia__titulo">Un poco de historia...</h2>
            <p class="historia__parrafo">
                Fundada el 27 de febrero de 2018, surge de la transformación del Colegio Universitario “Francisco de Miranda”, el Colegio Universitario “Profesor José Lorenzo Pérez Rodríguez” y el Colegio Universitario de Caracas, según el Decreto Presidencial N° 3.293 publicado en la Gaceta Oficial Extraordinaria N° 41.349, en el marco de la Misión Alma Mater.
            </p>
        </div>
        <?php boton(colocar_enlace('historia')); ?>
    </section>

    <section class="carreras">
        <div class="carreras__contenido">
            <h2 class="carreras__titulo">Programas Académicos</h2>
            <div class="carreras__lista">
                <?= carreras($data_carrera); ?>
            </div>
            <div class="carreras__contenedor-botones">
                <div class="carreras__boton carreras__boton--izquierda">
                    <?= colocar_svg('@imagenes/iconos/flecha.svg'); ?>
                </div>
                <div class="carreras__boton carreras__boton--derecha">
                    <?= colocar_svg('@imagenes/iconos/flecha.svg'); ?>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= colocar_ruta_html('@scripts/slider.js')?>"> </script>
</main>