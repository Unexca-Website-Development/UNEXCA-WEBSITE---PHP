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
			contenedor.appendChild(btnBajar)
		}

		if (this.mostrarBorrar) {
			const btnBorrar = await crearBoton({ rutaIcono: '/imagenes/iconos/icon_borrar.svg', clase: '-borrar' })
			contenedor.appendChild(btnBorrar)
		}

		control.appendChild(contenedor)
		this.elemento = control
		return control
	}
}
