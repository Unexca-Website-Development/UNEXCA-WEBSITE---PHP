import BotonAgregarBloque from './BotonAgregarBloque.js'

export default class MenuAgregarBloques {
	constructor(opciones = []) {
		this.opciones = opciones
		this.menu = document.createElement('div')
		this.menu.className = 'agregar-bloque__menu'
	}

	async renderizar() {
		for (const opt of this.opciones) {
			const boton = new BotonAgregarBloque(opt.icono, opt.texto, opt.tipo)
			this.menu.appendChild(await boton.renderizar())
		}
		return this.menu
	}
}
