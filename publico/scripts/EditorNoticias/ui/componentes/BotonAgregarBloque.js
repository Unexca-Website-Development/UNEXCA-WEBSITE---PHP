import { crearBoton } from '../utilidadesUI.js'
import EditorControlador from '../../controladores/EditorControlador.js'

export default class BotonAgregarBloque {
	constructor(rutaIcono, texto, tipo) {
		this.tipo = tipo
		this.rutaIcono = rutaIcono
		this.texto = texto
		this.controlador = new EditorControlador()
	}

	async renderizar() {
		const boton = await crearBoton({
			rutaIcono: this.rutaIcono,
			texto: this.texto,
			clase: 'agregar-bloque__opcion',
			tipo: 'button',
			claseSpan: 'agregar-bloque__texto'
		})

		boton.addEventListener('click', () => {
			this.controlador.agregarBloque(this.tipo)
		})

		return boton
	}
}