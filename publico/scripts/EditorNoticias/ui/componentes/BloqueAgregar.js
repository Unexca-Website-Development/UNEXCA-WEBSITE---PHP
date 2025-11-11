import MenuAgregarBloques from './MenuAgregarBloques.js'
import IconoSVG from './IconoSVG.js'

export default class BloqueAgregar {
	constructor(opciones = [], textoBoton = 'Agregar bloque', rutaIcono = '') {
		this.contenedor = document.createElement('div')
		this.contenedor.className = 'editor-noticia__bloque'

		this.boton = document.createElement('button')
		this.boton.className = 'bloque-titulo bloque-titulo--accion agregar-bloque__boton'
		this.textoBoton = textoBoton
		this.rutaIcono = rutaIcono

		this.menu = new MenuAgregarBloques(opciones)
	}

	async renderizar() {
		// Renderizar el SVG en el botón principal
		if (this.rutaIcono) {
			const icono = new IconoSVG(this.rutaIcono)
			await icono.cargar()
			this.boton.appendChild(icono.renderizar())
		}

		const span = document.createElement('span')
		span.className = 'bloque-titulo__texto'
		span.textContent = this.textoBoton
		this.boton.appendChild(span)

		// Renderizar el menú de opciones
		const menuRenderizado = await this.menu.renderizar()
		this.contenedor.appendChild(this.boton)
		this.contenedor.appendChild(menuRenderizado)

		return this.contenedor
	}
}
