export default class TextareaBloque {
	constructor(id, placeholder = '', requerido = false) {
		this.id = id
		this.placeholder = placeholder
		this.requerido = requerido
		this.elemento = null
	}

	renderizar() {
		const textarea = document.createElement('textarea')
		textarea.className = 'editor-noticia__campo-texto'
		textarea.id = this.id
		textarea.placeholder = this.placeholder
		if (this.requerido) textarea.required = true

		this.elemento = textarea
		return textarea
	}
}
