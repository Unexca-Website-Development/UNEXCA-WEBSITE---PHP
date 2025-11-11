import { crearIcono } from '../utilidadesUI.js'

export default class BotonAgregarBloque {
	constructor(rutaIcono, texto, tipo) {
		this.boton = document.createElement('button')
		this.boton.type = 'button'
		this.boton.className = 'agregar-bloque__opcion'
		this.tipo = tipo
		this.rutaIcono = rutaIcono
		this.texto = texto
	}

	async renderizar() {
		const icono = await crearIcono(this.rutaIcono)
		this.boton.appendChild(icono.renderizar())

		const span = document.createElement('span')
		span.className = 'agregar-bloque__texto'
		span.textContent = this.texto
		this.boton.appendChild(span)

		return this.boton
	}
}
