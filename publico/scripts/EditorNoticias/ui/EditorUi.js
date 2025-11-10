export default class EditorUI {
	constructor(contenedorRaiz) {
		this.contenedorRaiz = contenedorRaiz
		this.editor = null
	}

	inicializar() {
		this.editor = document.createElement('div')
		this.editor.className = 'editor'
		this.contenedorRaiz.innerHTML = ''
		this.contenedorRaiz.appendChild(this.editor)
	}

	obtenerContenedor() {
		return this.editor
	}
}