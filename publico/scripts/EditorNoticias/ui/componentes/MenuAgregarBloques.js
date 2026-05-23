import BotonAgregarBloque from './BotonAgregarBloque.js'

export default class MenuAgregarBloques {
	constructor(opciones = []) {
		this.opciones = opciones
		this.menu = document.createElement('div')
		this.menu.className = 'agregar-bloque__menu'
	}

	async renderizar() {
		// Opcional: Agregar un pequeño título al menú
		const titulo = document.createElement('div')
		titulo.className = 'agregar-bloque__menu-titulo'
		titulo.style.gridColumn = '1 / -1'
		titulo.style.fontSize = '0.8rem'
		titulo.style.color = 'var(--gris-oscuro)'
		titulo.style.marginBottom = '0.5rem'
		titulo.style.fontWeight = '700'
		titulo.style.textTransform = 'uppercase'
		titulo.innerText = 'Selecciona un tipo de bloque'
		this.menu.appendChild(titulo)

		for (const opt of this.opciones) {
			const boton = new BotonAgregarBloque(opt.icono, opt.texto, opt.tipo)
			this.menu.appendChild(await boton.renderizar())
		}
		return this.menu
	}
}
