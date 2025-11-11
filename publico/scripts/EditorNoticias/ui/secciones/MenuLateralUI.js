import { crearBoton } from '../utilidadesUI.js'

export default class MenuLateralUI {
	constructor() {
		this.elemento = null
	}

	async renderizar() {
		const nav = document.createElement('nav')
		nav.className = 'menu-editor'

		const botonesConfig = [
			{ id: 'btn-menu-abrir', rutaIcono: '/imagenes/iconos/icon_menu_open.svg', clase: 'menu-editor__boton' },
			{ id: 'btn-nueva-noticia', rutaIcono: '/imagenes/iconos/icon_nueva.svg', texto: 'Nueva noticia', clase: 'menu-editor__boton', claseSpan: 'menu-editor__texto' },
			{ id: 'btn-buscar-noticia', rutaIcono: '/imagenes/iconos/icon_buscar.svg', texto: 'Buscar noticia', clase: 'menu-editor__boton', claseSpan: 'menu-editor__texto' },
			{ id: 'btn-guardar-noticia', rutaIcono: '/imagenes/iconos/icon_guardar.svg', texto: 'Guardar noticia', clase: 'menu-editor__boton', claseSpan: 'menu-editor__texto' },
			{ id: 'btn-publicar-noticia', rutaIcono: '/imagenes/iconos/icon_publicar.svg', texto: 'Publicar noticia', clase: 'menu-editor__boton', claseSpan: 'menu-editor__texto' }
		]

		for (const config of botonesConfig) {
			const boton = await crearBoton({
				rutaIcono: config.rutaIcono,
				texto: config.texto,
				clase: config.clase,
				claseSpan: config.claseSpan
			})
			boton.id = config.id
			nav.appendChild(boton)
		}

		const grupoRecientes = document.createElement('div')
		grupoRecientes.className = 'menu-editor__grupo menu-editor__grupo--recientes'

		const botonRecientes = await crearBoton({
			rutaIcono: '/imagenes/iconos/flecha.svg',
			texto: 'Noticias recientes',
			clase: 'menu-editor__boton menu-editor__boton--recientes',
			claseSpan: 'menu-editor__texto'
		})
		botonRecientes.id = 'btn-noticias-recientes'

		const contenedorRecientes = document.createElement('div')
		contenedorRecientes.className = 'menu-editor__contenedor-recientes'

		grupoRecientes.append(botonRecientes, contenedorRecientes)

		const btnGuardar = nav.querySelector('#btn-guardar-noticia')
		if (btnGuardar) nav.insertBefore(grupoRecientes, btnGuardar)

		this.elemento = nav
		return nav
	}
}
