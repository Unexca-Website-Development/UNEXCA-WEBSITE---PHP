import { generarId, asignarDatosBloque } from "../utilidades/utilidades.js"

export default class BloqueBase {
	constructor(tipo, texto = '') {
		this.tipo = tipo
		this.id = generarId(this.tipo)
		this.texto = texto
		this.campos = {}
	}

	obtenerDatos() {
		return {
			id: this.id,
			tipo: this.tipo,
			texto: this.texto,
			contenido: {...this.campos}
		}
	}

	asignar(datos) {
		asignarDatosBloque(this, datos)
	}
}