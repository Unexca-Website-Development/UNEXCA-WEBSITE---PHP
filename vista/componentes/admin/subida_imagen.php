<?php
// Componente reutilizable para subida de imágenes en el panel de admin.
//
// USO:
// Incluir este componente en las vistas de administración donde se necesite.
//
// Parámetros a pasar al incluir el componente:
// - $idEntidad (int): ID de la entidad (autoridad, nucleo, etc.) que se edita.
// - $rutaImagenActual (string): Ruta de la imagen actual para la vista previa.
// - $endpoint (string): El endpoint específico para la subida (ej. 'admin-subir-imagen-autoridad').

// Valores por defecto para seguridad y robustez
$idEntidad = $idEntidad ?? 0;
$rutaImagenActual = $rutaImagenActual ?? colocar_enlace('/publico/imagenes/iconos/icon_imagen.svg');
$endpoint = $endpoint ?? '';

// ID único para el componente, para evitar conflictos si se usa varias veces en una página
$idComponente = 'upload-component-' . uniqid();
?>

<div class="subida-imagen-componente" id="<?= $idComponente ?>">
    <div class="imagen-preview-container">
        <img src="<?= $rutaImagenActual ?>" alt="Vista previa de la imagen" class="imagen-preview">
    </div>

    <form class="subida-form" enctype="multipart/form-data">
        <label class="input-archivo-label" for="input-archivo-<?= $idComponente ?>">Seleccionar archivo...</label>
        <input type="file" name="imagen" id="input-archivo-<?= $idComponente ?>" class="input-archivo" accept="image/jpeg, image/png, image/gif">
        
        <button type="button" 
                class="boton-subir js-subir-imagen-btn" 
                data-endpoint="<?= $endpoint ?>" 
                data-id-entidad="<?= $idEntidad ?>"
                data-component-id="<?= $idComponente ?>">
            Subir Nueva Imagen
        </button>
        
        <div class="subida-status"></div>
    </form>
</div>
