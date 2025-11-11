import Contenedor from '../componentes/Contenedor.js'

export default class ContenedorSeccion {
	constructor(titulo = '') {
		this.seccion = document.createElement('section')
		this.seccion.className = 'editor-noticia__seccion'

		this.boton = document.createElement('button')
		this.boton.className = 'editor-noticia__boton-desplegable'
		this.boton.innerHTML = `<span class="editor-noticia__titulo-seccion">${titulo}</span>`

		this.contenido = new Contenedor('editor-noticia__contenido-desplegable')

		this.seccion.appendChild(this.boton)
		this.seccion.appendChild(this.contenido.renderizar())
	}

	agregarContenido(elemento) {
		this.contenido.agregarContenido(elemento)
	}

	renderizar() {
		return this.seccion
	}
}
