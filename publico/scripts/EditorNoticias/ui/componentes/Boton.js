import { crearIcono } from '../utilidadesUI.js'

export default class Boton {
	constructor({ rutaIcono = '', texto = '', clase = '', tipo = 'button', mostrarTexto = true, claseSpan = 'boton__texto' } = {}) {
		this.boton = document.createElement('button')
		this.boton.type = tipo
		this.boton.className = clase
		this.rutaIcono = rutaIcono
		this.texto = texto
		this.mostrarTexto = mostrarTexto
		this.claseSpan = claseSpan
	}

	async renderizar() {
		if (this.rutaIcono) {
			const icono = await crearIcono(this.rutaIcono)
			this.boton.appendChild(icono.renderizar())
		}

		if (this.mostrarTexto && this.texto) {
			const span = document.createElement('span')
			span.className = this.claseSpan
			span.textContent = this.texto
			this.boton.appendChild(span)
		}

		return this.boton
	}
}
