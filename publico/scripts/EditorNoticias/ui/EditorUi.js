import EditorNoticiaUI from './secciones/EditorNoticiaUI.js'
import MenuLateralUI from './secciones/MenuLateralUI.js'

export default class EditorUI {
	constructor(contenedorRaiz) {
		this.contenedorRaiz = contenedorRaiz
		this.dom = {}
		this.menuLateral = new MenuLateralUI()
		this.editorNoticia = new EditorNoticiaUI()
	}

	async renderizarBase() {
		this.contenedorRaiz.innerHTML = ''

		const principal = document.createElement('div')
		principal.className = 'principal'
		principal.id = 'principal'

		const editorNoticiaElemento = await this.editorNoticia.renderizar()
		const menuLateralElemento = await this.menuLateral.renderizar()

		principal.append(editorNoticiaElemento, menuLateralElemento)
		this.contenedorRaiz.appendChild(principal)

		this.dom = {
			principal,
			editorNoticia: editorNoticiaElemento,
			menuLateral: menuLateralElemento,
			...this.editorNoticia.obtenerReferencias()
		}
	}
	
	obtenerReferencias() {
		return this.dom
	}
}