import EditorUI from './ui/EditorUi.js'

async function iniciarEditor() {
	const contenedor = document.getElementById('editor-principal')
	if (!contenedor) throw new Error('No se encontró el contenedor #editor-principal')

	const ui = new EditorUI(contenedor)

	await ui.renderizarBase()

}

document.addEventListener('DOMContentLoaded', iniciarEditor)
