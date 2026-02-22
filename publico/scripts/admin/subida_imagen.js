/**
 * Lógica para el componente de subida de imágenes.
 * Detecta los botones de subida, maneja la comunicación con el servidor
 * y actualiza la interfaz de usuario.
 */
document.addEventListener('DOMContentLoaded', () => {

    /**
     * Busca y asigna el evento de clic a los botones de subida dentro de un contenedor.
     * @param {Element} container - El elemento HTML dentro del cual buscar botones.
     */
    const initUploadButtons = (container) => {
        // Se buscan botones que tengan la clase y que no hayan sido ya inicializados.
        const uploadButtons = container.querySelectorAll('.js-subir-imagen-btn:not([data-initialized])');

        uploadButtons.forEach(button => {
            button.dataset.initialized = 'true'; // Marcar como inicializado
            button.addEventListener('click', handleUpload);
        });
    };

    /**
     * Maneja todo el proceso de subida cuando se hace clic en un botón.
     * @param {Event} event - El evento de clic.
     */
    async function handleUpload(event) {
        const button = event.currentTarget;
        const componentId = button.dataset.componentId;
        const component = document.getElementById(componentId);

        if (!component) {
            console.error('Error: No se encontró el componente de subida asociado.');
            return;
        }

        const fileInput = component.querySelector('.input-archivo');
        const statusDiv = component.querySelector('.subida-status');
        const previewImg = component.querySelector('.imagen-preview');

        const endpoint = button.dataset.endpoint;
        const entityId = button.dataset.idEntidad;
        const file = fileInput.files[0];

        // Validaciones del lado del cliente
        if (!file) {
            statusDiv.textContent = 'Por favor, selecciona un archivo primero.';
            statusDiv.style.color = 'orange';
            return;
        }
        if (!endpoint || !entityId) {
            statusDiv.textContent = 'Error de configuración del componente.';
            statusDiv.style.color = 'red';
            console.error('Faltan los atributos data-endpoint o data-id-entidad en el botón.');
            return;
        }

        const formData = new FormData();
        formData.append('imagen', file);
        formData.append('id', entityId);

        // Actualizar UI para mostrar que la subida está en progreso
        statusDiv.textContent = 'Subiendo...';
        statusDiv.style.color = 'blue';
        button.disabled = true;

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || `Error del servidor: ${response.statusText}`);
            }

            statusDiv.textContent = '¡Subida completada con éxito!';
            statusDiv.style.color = 'green';

            // Actualizar la vista previa con la nueva imagen.
            // Se añade un timestamp para evitar problemas de caché del navegador.
            previewImg.src = result.ruta + '?t=' + new Date().getTime();

        } catch (error) {
            console.error('Error en la subida:', error);
            statusDiv.textContent = `Error: ${error.message}`;
            statusDiv.style.color = 'red';
        } finally {
            button.disabled = false; // Reactivar el botón
        }
    }

    // 1. Inicializar botones en la carga inicial de la página
    initUploadButtons(document.body);

    // 2. Usar MutationObserver para detectar contenido cargado dinámicamente
    //    (cumpliendo la sugerencia del usuario de revisar desplegables.js)
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if (mutation.addedNodes.length) {
                mutation.addedNodes.forEach(node => {
                    // Solo nos interesan los nodos de tipo Elemento
                    if (node.nodeType === 1) {
                        initUploadButtons(node);
                    }
                });
            }
        });
    });

    // Observar cambios en todo el cuerpo del documento (subtree)
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
