import EditorNoticiaUI from './secciones/EditorNoticiaUI.js'

export default class EditorUI {
	constructor(contenedorRaiz) {
		this.contenedorRaiz = contenedorRaiz
		this.dom = {}
		this.editorNoticia = new EditorNoticiaUI()
	}

	async renderizarBase() {
		this.contenedorRaiz.innerHTML = ''

		const principal = document.createElement('div')
		principal.className = 'principal'
		principal.id = 'principal'

		const editorNoticiaElemento = await this.editorNoticia.renderizar()
		principal.appendChild(editorNoticiaElemento)

		this.contenedorRaiz.appendChild(principal)

		this.dom = {
			principal,
			...this.editorNoticia.obtenerReferencias()
		}
	}
	
	obtenerReferencias() {
		return this.dom
	}
}

// Para probar
const contenedor = document.getElementById('editor-principal')
const ui = new EditorUI(contenedor)
ui.renderizarBase()
