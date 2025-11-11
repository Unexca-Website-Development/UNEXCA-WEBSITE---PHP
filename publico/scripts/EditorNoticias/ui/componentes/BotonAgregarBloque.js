import { crearBoton } from '../utilidadesUI.js'

export default class BotonAgregarBloque {
	constructor(rutaIcono, texto, tipo) {
		this.tipo = tipo
		this.rutaIcono = rutaIcono
		this.texto = texto
	}

	async renderizar() {
		return await crearBoton({
			rutaIcono: this.rutaIcono,
			texto: this.texto,
			clase: 'agregar-bloque__opcion',
			tipo: 'button',
			claseSpan: 'agregar-bloque__texto'
		})
	}
}
