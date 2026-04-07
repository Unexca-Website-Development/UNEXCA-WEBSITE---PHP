export default class TextareaBloque {
	constructor(id, key, placeholder = '', requerido = false) {
		this.id = id
		this.key = key
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
		textarea.setAttribute('data-key', this.key)

		this.elemento = textarea
		return textarea
	}
}
