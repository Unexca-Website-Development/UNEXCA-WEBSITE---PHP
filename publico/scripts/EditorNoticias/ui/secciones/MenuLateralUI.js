import { crearBoton } from '../utilidadesUI.js'
import EditorControlador from '../../controladores/EditorControlador.js'
import { administradorEventos } from '../../utilidades/AdministradorEventos.js'

export const CONFIG_MENU_LATERAL = [
	{
		id: 'btn-menu-abrir',
		rutaIcono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_menu_open.svg',
		clase: 'menu-editor__boton'
	},
	{
		id: 'btn-nueva-noticia',
		rutaIcono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_nueva.svg',
		texto: 'Nueva noticia',
		clase: 'menu-editor__boton',
		claseSpan: 'menu-editor__texto'
	},
	{
		id: 'btn-buscar-noticia',
		rutaIcono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_buscar.svg',
		texto: 'Buscar noticia',
		clase: 'menu-editor__boton',
		claseSpan: 'menu-editor__texto'
	},
	{
		id: 'btn-guardar-noticia',
		rutaIcono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_guardar.svg',
		texto: 'Guardar noticia',
		clase: 'menu-editor__boton',
		claseSpan: 'menu-editor__texto'
	},
	{
		id: 'btn-publicar-noticia',
		rutaIcono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_publicar.svg',
		texto: 'Publicar noticia',
		clase: 'menu-editor__boton',
		claseSpan: 'menu-editor__texto'
	}
]

export const CONFIG_MENU_RECIENTES = {
	id: 'btn-noticias-recientes',
	rutaIcono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/flecha.svg',
	texto: 'Noticias recientes',
	clase: 'menu-editor__boton menu-editor__boton--recientes',
	claseSpan: 'menu-editor__texto'
}

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
		if (btnGuardar) {
			menuContenedor.insertBefore(grupoRecientes, btnGuardar)
		}

		nav.appendChild(menuContenedor)
		this.elemento = nav

		// Eventos
		menuContenedor.querySelector('#btn-nueva-noticia')?.addEventListener('click', () => {
			this.controlador.nuevoDocumento()
			administradorEventos.notificar('bloquesActualizados', this.controlador.convertirParaUI(this.controlador.modelo.bloques))
		})

		menuContenedor.querySelector('#btn-buscar-noticia')?.addEventListener('click', () => {
			administradorEventos.notificar('abrirPanelBusqueda')
		})

		botonRecientes.addEventListener('click', () => {
			contenedorRecientes.classList.toggle('-activado')
		})

		menuContenedor.querySelector('#btn-guardar-noticia').addEventListener('click', () => {
			this.controlador.establecerEstado('borrador')
			this.controlador.guardarNoticia()
			// console.log('Guardar datos:', this.controlador.obtenerDatos())
		})

		menuContenedor.querySelector('#btn-publicar-noticia')?.addEventListener('click', () => {
			this.controlador.establecerEstado('publicado')
			this.controlador.guardarNoticia()
			console.log('Guardar datos:', this.controlador.obtenerDatos())
		})

		return nav
	}
}
