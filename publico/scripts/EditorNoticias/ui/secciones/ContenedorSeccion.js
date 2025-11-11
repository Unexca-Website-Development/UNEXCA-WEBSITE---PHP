import Contenedor from '../componentes/Contenedor.js'
import { crearBoton } from '../utilidadesUI.js'

export default class ContenedorSeccion {
	constructor(titulo = '') {
		this.seccion = document.createElement('section')
		this.seccion.className = 'editor-noticia__seccion'
		this.titulo = titulo
		this.contenido = new Contenedor('editor-noticia__contenido-desplegable')
	}

	async renderizar() {
		const boton = await crearBoton({
			texto: this.titulo,
			clase: 'editor-noticia__boton-desplegable',
			claseSpan: 'editor-noticia__titulo-seccion'
		})

		this.seccion.appendChild(boton)
		this.seccion.appendChild(this.contenido.renderizar())

		return this.seccion
	}

	agregarContenido(elemento) {
		this.contenido.agregarContenido(elemento)
	}
}
