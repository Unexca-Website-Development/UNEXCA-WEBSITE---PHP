<?php
/**
 * @var array $noticia Datos principales de la noticia
 * @var array $contenido Bloques de contenido de la noticia
 */
?>
<main class="noticia-detalle">
    <header class="noticia-detalle__header" style="background-color: var(--azul); color: var(--blanco); padding: 6rem 2rem; text-align: center;">
        <div class="contenedor" style="max-width: 900px; margin: 0 auto;">
            <h1 style="font-size: 3rem; font-family: var(--fuente-titulos); margin-bottom: 1.5rem; text-transform: uppercase;">
                <?= htmlspecialchars($noticia['titulo_principal']) ?>
            </h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">
                Publicado el: <?= date('d/m/Y', strtotime($noticia['fecha_publicacion'])) ?>
            </p>
        </div>
    </header>

    <div class="noticia-detalle__cuerpo" style="max-width: 800px; margin: 4rem auto; padding: 0 2rem; line-height: 1.8; font-size: 1.1rem; color: var(--negro);">
        
        <?php if (!empty($noticia['imagen_principal'])): ?>
            <figure style="margin-bottom: 3rem; text-align: center;">
                <img src="<?= resolver_url_asset($noticia['imagen_principal']) ?>" 
                     alt="<?= htmlspecialchars($noticia['descripcion_imagen'] ?? $noticia['titulo_principal']) ?>"
                     style="width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <?php if (!empty($noticia['descripcion_imagen'])): ?>
                    <figcaption style="margin-top: 1rem; font-style: italic; color: #666; font-size: 0.9rem;">
                        <?= htmlspecialchars($noticia['descripcion_imagen']) ?>
                    </figcaption>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <div class="noticia-detalle__descripcion-corta" style="font-weight: 600; font-size: 1.3rem; margin-bottom: 3rem; color: var(--azul);">
            <?= nl2br(htmlspecialchars($noticia['descripcion_corta'])) ?>
        </div>

        <div class="noticia-detalle__bloques">
            <?php foreach ($contenido as $bloque): 
                $datos = json_decode($bloque['datos'], true);
                $tipo = $bloque['tipo_bloque'];
            ?>
                <div class="bloque bloque--<?= $tipo ?>" style="margin-bottom: 2rem;">
                    <?php switch ($tipo):
                        case 'titulo': ?>
                            <h2 style="font-size: 2rem; color: var(--azul); margin-top: 3rem; margin-bottom: 1.5rem; font-family: var(--fuente-titulos);">
                                <?= htmlspecialchars($datos['texto'] ?? '') ?>
                            </h2>
                            <?php break; ?>

                        case 'subtitulo': ?>
                            <h3 style="font-size: 1.5rem; color: var(--azul); margin-top: 2.5rem; margin-bottom: 1.2rem; font-family: var(--fuente-titulos);">
                                <?= htmlspecialchars($datos['texto'] ?? '') ?>
                            </h3>
                            <?php break; ?>

                        case 'parrafo': ?>
                            <p>
                                <?= nl2br(htmlspecialchars($datos['texto'] ?? '')) ?>
                            </p>
                            <?php break; ?>

                        case 'cita': ?>
                            <blockquote style="border-left: 4px solid var(--azul); padding-left: 1.5rem; font-style: italic; margin: 2rem 0;">
                                <p style="font-size: 1.4rem; margin-bottom: 0.5rem;">"<?= htmlspecialchars($datos['texto'] ?? '') ?>"</p>
                                <?php if (!empty($datos['autor'])): ?>
                                    <cite style="display: block; text-align: right; font-weight: bold;">— <?= htmlspecialchars($datos['autor']) ?></cite>
                                <?php endif; ?>
                            </blockquote>
                            <?php break; ?>

                        case 'imagen': ?>
                            <figure style="margin: 3rem 0; text-align: center;">
                                <img src="<?= resolver_url_asset($datos['url'] ?? '') ?>" 
                                     alt="<?= htmlspecialchars($datos['descripcion'] ?? '') ?>"
                                     style="max-width: 100%; height: auto; border-radius: 4px;">
                                <?php if (!empty($datos['descripcion'])): ?>
                                    <figcaption style="margin-top: 1rem; font-style: italic; color: #666; font-size: 0.9rem;">
                                        <?= htmlspecialchars($datos['descripcion']) ?>
                                    </figcaption>
                                <?php endif; ?>
                            </figure>
                            <?php break; ?>
                    <?php endswitch; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="margin-top: 6rem; text-align: center; border-top: 1px solid #eee; padding-top: 3rem;">
            <a href="<?= colocar_enlace('inicio') ?>" class="btn btn--primary" style="text-decoration: none; padding: 1rem 2rem; background-color: var(--azul); color: white; border-radius: 4px; font-weight: bold;">
                Volver al Inicio
            </a>
        </div>
    </div>
</main>
