import {CONFIG_MENU_LATERAL} from '../../config/configMenuLateral.js'
import { crearBoton } from '../utilidadesUI.js'
import EditorControlador from '../../controladores/EditorControlador.js'

export default class MenuLateralUI {
	constructor() {
		this.elemento = null
		this.controlador = new EditorControlador()
	}

	async renderizar() {
		const nav = document.createElement('nav')
		nav.className = 'menu-editor'

		const menuContenedor = document.createElement('div')
		menuContenedor.className = 'menu-editor__contenedor'

		for (const config of CONFIG_MENU_LATERAL) {
			const boton = await crearBoton({
				rutaIcono: config.rutaIcono,
				texto: config.texto,
				clase: config.clase,
				claseSpan: config.claseSpan
			})
			boton.id = config.id
			menuContenedor.appendChild(boton)
		}

		nav.appendChild(menuContenedor)
		this.elemento = nav

		menuContenedor.querySelector('#btn-nueva-noticia')?.addEventListener('click', () => {
			this.controlador.nuevoDocumento()
		})

		menuContenedor.querySelector('#btn-guardar-noticia')?.addEventListener('click', () => {
			this.controlador.establecerEstado('borrador')
			this.controlador.guardarNoticia()
		})

		menuContenedor.querySelector('#btn-publicar-noticia')?.addEventListener('click', () => {
			this.controlador.establecerEstado('publicado')
			this.controlador.guardarNoticia()
		})

		return nav
	}
}
