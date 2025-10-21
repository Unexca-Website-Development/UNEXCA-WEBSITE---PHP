<!DOCTYPE html>
<html lang="ES">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/index.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/paginas/general.css')?>">
    <link rel="stylesheet" href="<?= colocar_ruta_html('@estilos/paginas/editorNoticias.css')?>">

    <!-- Iconos de las paginas -->
    <link rel="shortcut icon" href="<?= colocar_ruta_html('@imagenes/iconos/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= colocar_ruta_html('@imagenes/iconos/favicon-16x16.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= colocar_ruta_html('@imagenes/iconos/favicon-32x32.png') ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= colocar_ruta_html('@imagenes/iconos/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= colocar_ruta_html('@imagenes/iconos/android-chrome-192x192.png') ?>">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= colocar_ruta_html('@imagenes/iconos/android-chrome-512x512.png') ?>">

    <?php renderizar_head($head_data ?? []); ?>
</head>
<body>
    <div class="principal" id="principal">
        <div class="editor-noticia">
            
            <!-- SECCIÓN: Información General -->
            <section class="editor-noticia__seccion">
                <button class="editor-noticia__boton-desplegable">
                    <span class="editor-noticia__titulo-seccion">Titular de la noticia</span>
                    <?= colocar_svg('@imagenes/iconos/flecha.svg') ?>
                </button>

                <div class="editor-noticia__contenido-desplegable">
                    <div class="editor-noticia__contenido-bloques -estaticos">
<<<<<<< HEAD
                        <!-- Contenido Estatico -->
=======
                        <!-- Bloque de Fechas -->
                        <div class="editor-noticia__bloque editor-noticia__bloque--fechas">
                            <label class="bloque-titulo">
                                <?= colocar_svg('@imagenes/iconos/icon_fecha.svg') ?>
                                <span class="bloque-titulo__texto">Información de la noticia</span>
                            </label>

                            <div class="editor-noticia__grupo-fechas">
                                <div class="editor-noticia__campo-fecha">
                                    <label for="fecha_creacion">Fecha de creación:</label>
                                    <input type="date" id="fecha_creacion" name="fecha_creacion" readonly>
                                </div>

                                <div class="editor-noticia__campo-fecha">
                                    <label for="fecha_publicacion">Fecha de publicación:</label>
                                    <input type="date" id="fecha_publicacion" name="fecha_publicacion">
                                </div>

                                <div class="editor-noticia__campo-fecha">
                                    <label for="fecha_modificacion">Última modificación:</label>
                                    <input type="date" id="fecha_modificacion" name="fecha_modificacion" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Bloque: Título -->
                        <div class="editor-noticia__bloque">
                            <label class="bloque-titulo" for="titulo">
                                <?= colocar_svg('@imagenes/iconos/icon_h1.svg') ?>
                                <span class="bloque-titulo__texto">Título de la noticia:</span>
                            </label>
                            <textarea class="editor-noticia__campo-texto editor-noticia__campo-texto--titulo" id="titulo" placeholder="Escribe el título aquí..." required></textarea>
                        </div>

                        <!-- Bloque: Descripción -->
                        <div class="editor-noticia__bloque">
                            <label class="bloque-titulo" for="descripcion">
                                <?= colocar_svg('@imagenes/iconos/icon_descripcion.svg') ?>
                                <span class="bloque-titulo__texto">Descripción de la noticia:</span>
                            </label>
                            <textarea class="editor-noticia__campo-texto" id="descripcion" name="descripcion" placeholder="Escribe la descripción aquí..." required></textarea>
                        </div>

                        <!-- Bloque: Imagen principal -->
                        <div class="editor-noticia__bloque">
                            <label class="bloque-titulo" for="imagen">
                                <?= colocar_svg('@imagenes/iconos/icon_imagen.svg') ?>
                                <span class="bloque-titulo__texto">Imagen principal:</span>
                            </label>
                            <input class="editor-noticia__campo-archivo" id="imagen" type="file" accept=".png,.jpg,.jpeg,.webp" required>
                            <textarea class="editor-noticia__campo-texto" id="descripcion_imagen" name="descripcion_imagen" placeholder="Escribe la descripción de la imagen aquí..." required></textarea>
                        </div>
>>>>>>> c30902c (Implementación del nuevo editor de noticias con bloques dinámicos)
                    </div>
                </div>
            </section>

            <!-- SECCIÓN: Contenido del Artículo -->
            <section class="editor-noticia__seccion">
                <button class="editor-noticia__boton-desplegable">
                    <span class="editor-noticia__titulo-seccion">Contenido del artículo</span>
                    <?= colocar_svg('@imagenes/iconos/flecha.svg') ?>
                </button>

                <div class="editor-noticia__contenido-desplegable">

                    <div class="editor-noticia__contenido-bloques -dinamicos">
                        <!-- Bloques de la Noticia -->
                    </div>

                    <div class="editor-noticia__bloque">
                        <button class="bloque-titulo bloque-titulo--accion agregar-bloque__boton">
                            <span class="bloque-titulo__texto">Agregar bloque</span>
                            <?= colocar_svg('@imagenes/iconos/icon_mas.svg') ?>
                        </button>

                        <div class="agregar-bloque__menu" id="menu-agregar-bloque">
                            <button type="button" class="agregar-bloque__opcion">
                                <?= colocar_svg('@imagenes/iconos/icon_h2.svg') ?>
                                <span class="agregar-bloque__texto">Subtítulo</span>
                            </button>
                            <button type="button" class="agregar-bloque__opcion">
                                <?= colocar_svg('@imagenes/iconos/icon_parrafo.svg') ?>
                                <span class="agregar-bloque__texto">Párrafo</span>
                            </button>
                            <button type="button" class="agregar-bloque__opcion">
                                <?= colocar_svg('@imagenes/iconos/icon_imagen.svg') ?>
                                <span class="agregar-bloque__texto">Imagen</span>
                            </button>
                            <button type="button" class="agregar-bloque__opcion">
                                <?= colocar_svg('@imagenes/iconos/icon_cita.svg') ?>
                                <span class="agregar-bloque__texto">Cita</span>
                            </button>
                            <button type="button" class="agregar-bloque__opcion">
                                <?= colocar_svg('@imagenes/iconos/icon_lista.svg') ?>
                                <span class="agregar-bloque__texto">Lista</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Menú lateral -->
        <nav class="menu-editor">
            <button class="menu-editor__boton">
                <?= colocar_svg('@imagenes/iconos/icon_menu_open.svg') ?>
            </button>

            <button class="menu-editor__boton">
                <?= colocar_svg('@imagenes/iconos/icon_nueva.svg') ?>
                <span class="menu-editor__texto">Nueva noticia</span>
            </button>
            
            <button class="menu-editor__boton">
                <?= colocar_svg('@imagenes/iconos/icon_buscar.svg') ?>
                <span class="menu-editor__texto">Buscar noticia</span>
            </button>

            <div class="menu-editor__grupo menu-editor__grupo--recientes">
                <button class="menu-editor__boton menu-editor__boton--recientes">
                    <?= colocar_svg('@imagenes/iconos/flecha.svg') ?>
                    <span class="menu-editor__texto">Noticias recientes</span>
                </button>
                <div class="menu-editor__contenedor-recientes"></div>
            </div>

            <button class="menu-editor__boton">
                <?= colocar_svg('@imagenes/iconos/icon_guardar.svg') ?>
                <span class="menu-editor__texto">Guardar noticia</span>
            </button>

            <button class="menu-editor__boton">
                <?= colocar_svg('@imagenes/iconos/icon_publicar.svg') ?>
                <span class="menu-editor__texto">Publicar noticia</span>
            </button> 
        </nav>
    </div>

    <script type="module" src="<?= colocar_ruta_html('@scripts/editor/main.js')?>"></script>
</body>
</html>
