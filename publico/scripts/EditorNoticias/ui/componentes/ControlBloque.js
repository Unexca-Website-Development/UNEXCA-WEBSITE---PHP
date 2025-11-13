import { crearBoton } from '../utilidadesUI.js'

export default class ControlBloque {
	constructor({ mostrarSubir = true, mostrarBajar = true, mostrarBorrar = true } = {}) {
		this.mostrarSubir = mostrarSubir
		this.mostrarBajar = mostrarBajar
		this.mostrarBorrar = mostrarBorrar
		this.elemento = null
	}

	async renderizar() {
		const control = document.createElement('div')

		if (this.mostrarSubir) {
			const btnSubir = await crearBoton({
				rutaIcono: '/imagenes/iconos/flecha.svg',
				clase: 'editor-noticia__boton-control -subir',
				tipo: 'button'
			})
			contenedor.appendChild(btnSubir)
		}

		if (this.mostrarBajar) {
			const btnBajar = await crearBoton({
				rutaIcono: '/imagenes/iconos/flecha.svg',
				clase: 'editor-noticia__boton-control -bajar',
				tipo: 'button'
			})
			contenedor.appendChild(btnBajar)
		}

		if (this.mostrarBorrar) {
			const btnBorrar = await crearBoton({
				rutaIcono: '/imagenes/iconos/icon_borrar.svg',
				clase: 'editor-noticia__boton-control -borrar',
				tipo: 'button'
			})
			contenedor.appendChild(btnBorrar)
		}

		control.appendChild(contenedor)
		this.elemento = control
		return control
	}
}
