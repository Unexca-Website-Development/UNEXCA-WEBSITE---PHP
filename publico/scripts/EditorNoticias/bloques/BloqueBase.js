import { generarId, asignarDatosBloque } from "../utilidades/utilidades.js"
import { CONFIG_BLOQUES } from "../config/configBloques.js"

export default class BloqueBase {
	constructor(tipo) {
		this.tipo = tipo
		this.id = generarId(this.tipo)
		const config = CONFIG_BLOQUES[tipo] || {}
		this.texto = config.texto || ''
		this.campos = { ...config.campos }
	}

	obtenerDatos() {
		return {
			id: this.id,
			tipo: this.tipo,
			texto: this.texto,
			contenido: { ...this.campos }
		}
	}

	asignar(datos) {
		asignarDatosBloque(this, datos)
	}
}
