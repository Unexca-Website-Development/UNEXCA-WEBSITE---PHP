export default class Contenedor {
	constructor(clase = '', id = '') {
		this.div = document.createElement('div')
		if (clase) this.div.className = clase
		if (id) this.div.id = id
	}

	agregarContenido(elemento) {
		this.div.appendChild(elemento)
	}

	renderizar() {
		return this.div
	}
}
