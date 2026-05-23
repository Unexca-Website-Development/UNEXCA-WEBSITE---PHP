import MenuAgregarBloques from './MenuAgregarBloques.js'
import { crearBoton } from '../utilidadesUI.js'

export default class BloqueAgregar {
	constructor(opciones = [], textoBoton = 'Agregar bloque', rutaIcono = '') {
		this.contenedor = document.createElement('div')
		this.contenedor.className = 'agregar-bloque'

		this.textoBoton = textoBoton
		this.rutaIcono = rutaIcono

		this.menu = new MenuAgregarBloques(opciones)
	}

	async renderizar() {
		// Renderizar el botón principal
		const boton = await crearBoton({
			rutaIcono: this.rutaIcono,
			texto: this.textoBoton,
			clase: 'agregar-bloque__boton',
			claseSpan: 'agregar-bloque__texto'
		})

		// Renderizar el menú de opciones
		const menuRenderizado = await this.menu.renderizar()
		
		boton.addEventListener('click', () => {
			menuRenderizado.classList.toggle('--visible')
		})

		this.contenedor.appendChild(boton)
		this.contenedor.appendChild(menuRenderizado)

		return this.contenedor
	}
}
