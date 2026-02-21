import {CONFIG_MENU_LATERAL, CONFIG_MENU_RECIENTES} from '../../config/configMenuLateral.js'
import { crearBoton } from '../utilidadesUI.js'
import EditorControlador from '../../controladores/EditorControlador.js'
import { administradorEventos } from '../../utilidades/AdministradorEventos.js'

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

		const grupoRecientes = document.createElement('div')
		grupoRecientes.className = 'menu-editor__grupo menu-editor__grupo--recientes'

		const botonRecientes = await crearBoton({
			rutaIcono: CONFIG_MENU_RECIENTES.rutaIcono,
			texto: CONFIG_MENU_RECIENTES.texto,
			clase: CONFIG_MENU_RECIENTES.clase,
			claseSpan: CONFIG_MENU_RECIENTES.claseSpan
		})
		botonRecientes.id = CONFIG_MENU_RECIENTES.id

		const contenedorRecientes = document.createElement('div')
		contenedorRecientes.className = 'menu-editor__contenedor-recientes'

		grupoRecientes.append(botonRecientes, contenedorRecientes)

		const btnGuardar = menuContenedor.querySelector('#btn-guardar-noticia')
		if (btnGuardar) menuContenedor.insertBefore(grupoRecientes, btnGuardar)

		nav.appendChild(menuContenedor)
		this.elemento = nav

		menuContenedor.querySelector('#btn-nueva-noticia')?.addEventListener('click', () => {
			this.controlador.nuevoDocumento()
		})

		menuContenedor.querySelector('#btn-buscar-noticia')?.addEventListener('click', () => {
			administradorEventos.notificar('abrirPanelBusqueda')
		})

		botonRecientes.addEventListener('click', () => {
			contenedorRecientes.classList.toggle('-activado')
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