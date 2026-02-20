<!--<div id="editor-principal"></div>-->

<form class="editor-noticia" id="formulario-test">
    <section class="editor-noticia__seccion">
        <button type="button" class ="editor_noticias__boton-desplegable">
            <span class="editor-noticia__titulo-seccion">Titular de la noticia</span>
        </button>
        <div class="editor-noticia__contenido-desplegable">
            <div class="editor-noticia__contenido-bloques -estaticos">
                <div class="editor-noticia__bloque">
                    <label for="titulo_principal" class="bloque-titulo">
                        <?= colocar_svg('@imagenes/iconos/icon_h1.svg') ?>
                        <span class="bloque-titulo__texto">Título</span>
                    </label>
                    <textarea 
                        class="editor-noticia__campo-texto" 
                        id="titulo_principal" 
                        placeholder="Escribe el título aquí..." 
                        data-key="texto"
                        name="titulo_principal"
                    ></textarea>
                </div>
                <div class="editor-noticia__bloque">
                    <label for="descripcion_corta" class="bloque-titulo">
                        <?= colocar_svg('@imagenes/iconos/icon_parrafo.svg') ?>
                        <span class="bloque-titulo__texto">Descripción Corta</span>
                    </label>
                    <textarea 
                        class="editor-noticia__campo-texto" 
                        id="descripcion_corta" 
                        placeholder="Escribe la descripción corta aquí..." 
                        data-key="texto"
                        name="descripcion_corta"
                    ></textarea>
                </div>
                <div class="editor-noticia__bloque">
                    <label for="imagen_principal" class="bloque-titulo">
                        <?= colocar_svg('@imagenes/iconos/icon_imagen.svg') ?>
                        <span class="bloque-titulo__texto">Imagen Principal</span>
                    </label>
                    <input 
                        type="file" 
                        id="imagen_principal" 
                        class="editor-noticia__campo-archivo" 
                        data-key="archivo" 
                        name="imagen_principal"
                    >
                    <textarea 
                        class="editor-noticia__campo-texto" 
                        id="imagen_principal" 
                        placeholder="Descripción de la imagen..." 
                        data-key="descripcion"
                        name="descripcion_imagen"
                    ></textarea>
                </div>
                <div class="editor-noticia__bloque">
                    <label for="url" class="bloque-titulo">
                        <?= colocar_svg('@imagenes/iconos/icon_calendario.svg') ?>
                        <span class="bloque-titulo__texto">Información Adicional</span>
                    </label>
                    <input
                        type="date" 
                        id="fecha_publicacion" 
                        class="editor-noticia__campo-archivo" 
                        data-key="fecha" 
                        name="fecha_publicacion"
                    >
                    <select name="estado" class="editor-noticia__campo-archivo">
                        <option value="borrador">Borrador</option>
                        <option value="publicado">Publicado</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="button" id="btn-guardar">Guardar Noticia</button>
    </section>
    <section class="editor-noticia__seccion">
        <!-- Aquí se agregarán los bloques dinámicos -->
    </section>
</form>

<script>
    document.getElementById('btn-guardar').addEventListener('click', function() {
        const form = document.getElementById('formulario-test');
        const data = Object.fromEntries(new FormData(form).entries());

        console.log('Datos a enviar:', JSON.stringify(data));
        fetch('<?= colocar_enlace('noticias_editor') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => console.log(res))
        .catch(err => console.error(err));
    });
</script>

<script type="module" src="<?= colocar_ruta_html('@scripts/EditorNoticias/main.js')?>"></script>