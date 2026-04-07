import EditorUI from './ui/EditorUi.js'
import EditorControlador from './controladores/EditorControlador.js'

async function iniciarEditor() {
	const contenedor = document.getElementById('editor-principal')
	if (!contenedor) throw new Error('No se encontró el contenedor #editor-principal')

	const ui = new EditorUI(contenedor)
	await ui.renderizarBase()

	// Cargar datos si existen
	if (window.noticiaData) {
		const controlador = new EditorControlador()
		
		// Unificar noticia y contenido para el controlador
		const datosCargar = {
			...window.noticiaData.noticia,
			id: window.noticiaData.noticia.noticia_id,
			bloques: window.noticiaData.contenido.map(b => ({
				tipo: b.tipo_bloque,
				datos: JSON.parse(b.datos)
			}))
		}
		
		controlador.cargarDatos(datosCargar)
	}
}

document.addEventListener('DOMContentLoaded', iniciarEditor)
