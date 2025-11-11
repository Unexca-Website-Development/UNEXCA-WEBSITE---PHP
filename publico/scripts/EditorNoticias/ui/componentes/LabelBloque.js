import { crearIcono } from '../utilidadesUI.js'

export default class LabelBloque {
	constructor(id, texto, rutaIcono) {
		this.id = id
		this.texto = texto
		this.rutaIcono = rutaIcono
		this.elemento = null
	}

	async renderizar() {
		const label = document.createElement('label')
		label.className = 'bloque-titulo'
		label.setAttribute('for', this.id)

		const icono = await crearIcono(this.rutaIcono)
		label.appendChild(icono.renderizar())

		const span = document.createElement('span')
		span.className = 'bloque-titulo__texto'
		span.textContent = this.texto
		label.appendChild(span)

		this.elemento = label
		return label
	}
}
