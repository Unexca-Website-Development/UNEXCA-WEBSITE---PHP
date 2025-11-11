export default class InputBloque {
	constructor(id, tipo = '', requerido = false, aceptar = '') {
		this.id = id
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

		this.elemento = input
		return input
	}
}
