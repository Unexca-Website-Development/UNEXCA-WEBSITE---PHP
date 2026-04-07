import MenuAgregarBloques from './MenuAgregarBloques.js'
import { crearBoton } from '../utilidadesUI.js'

export default class BloqueAgregar {
	constructor(opciones = [], textoBoton = 'Agregar bloque', rutaIcono = '') {
		this.contenedor = document.createElement('div')
		this.contenedor.className = 'editor-noticia__bloque'

		this.textoBoton = textoBoton
		this.rutaIcono = rutaIcono

		this.menu = new MenuAgregarBloques(opciones)
	}

	async renderizar() {
		// Renderizar el botón principal
		const boton = await crearBoton({
			rutaIcono: this.rutaIcono,
			texto: this.textoBoton,
			clase: 'bloque-titulo bloque-titulo--accion agregar-bloque__boton',
			claseSpan: 'bloque-titulo__texto'
		})

		// Renderizar el menú de opciones
		const menuRenderizado = await this.menu.renderizar()
		this.contenedor.appendChild(boton)
		this.contenedor.appendChild(menuRenderizado)

		return this.contenedor
	}
}
