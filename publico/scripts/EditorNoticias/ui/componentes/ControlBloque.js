import { crearBoton } from '../utilidadesUI.js'
import EditorControlador from '../../controladores/EditorControlador.js'

export default class ControlBloque {
	constructor(idBloque, { mostrarSubir = true, mostrarBajar = true, mostrarBorrar = true } = {}) {
		this.idBloque = idBloque
		this.mostrarSubir = mostrarSubir
		this.mostrarBajar = mostrarBajar
		this.mostrarBorrar = mostrarBorrar
		this.elemento = null
		this.controlador = new EditorControlador()
	}

	async renderizar() {
		const control = document.createElement('div')

		if (this.mostrarSubir) {
			const btnSubir = await crearBoton({
				rutaIcono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/flecha.svg',
				clase: 'editor-noticia__boton-control -subir',
				tipo: 'button'
			})
			btnSubir.addEventListener('click', () => {
				this.controlador.moverBloqueRelativo(this.idBloque, -1)
			})
			contenedor.appendChild(btnSubir)
		}

		if (this.mostrarBajar) {
			const btnBajar = await crearBoton({
				rutaIcono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/flecha.svg',
				clase: 'editor-noticia__boton-control -bajar',
				tipo: 'button'
			})
			btnBajar.addEventListener('click', () => {
				this.controlador.moverBloqueRelativo(this.idBloque, 1)
			})
			contenedor.appendChild(btnBajar)
		}

		if (this.mostrarBorrar) {
			const btnBorrar = await crearBoton({
				rutaIcono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_borrar.svg',
				clase: 'editor-noticia__boton-control -borrar',
				tipo: 'button'
			})
			btnBorrar.addEventListener('click', () => {
				this.controlador.eliminarBloque(this.idBloque)
			})
			contenedor.appendChild(btnBorrar)
		}

		control.appendChild(contenedor)
		this.elemento = control
		return control
	}
}
