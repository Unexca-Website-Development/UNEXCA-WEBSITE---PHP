export default class InputBloque {
	constructor(id, key, tipo = '', requerido = false, aceptar = '') {
		this.id = id
		this.key = key
		this.tipo = tipo
		this.requerido = requerido
		this.aceptar = aceptar
		this.elemento = null
	}

	renderizar() {
		const input = document.createElement('input')
		input.type = this.tipo
		input.id = this.id
		input.className = 'editor-noticia__campo-archivo'
		if (this.requerido) input.required = true
		if (this.tipo === 'file' && this.aceptar) input.accept = this.aceptar
		input.setAttribute('data-key', this.key)

		this.elemento = input
		return input
	}
}
