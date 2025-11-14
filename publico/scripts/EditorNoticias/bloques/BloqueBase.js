import { generarId } from "../utilidades/utilidades.js"
import { CONFIG_BLOQUES } from "../config/configBloques.js"

export default class BloqueBase {
	constructor(tipo) {
		this.tipo = tipo
		this.id = generarId(this.tipo)
		const config = CONFIG_BLOQUES[tipo] || {}
		this.texto = config.texto || ''
		this.contenido = {}

		for (const key in config.campos) {
			this.contenido[key] = config.campos[key] || ''
		}
	}

	obtenerDatos() {
		return {
			id: this.id,
			tipo: this.tipo,
			texto: this.texto,
			contenido: { ...this.contenido }
		}
	}

	asignar(datos) {
		if (!this.contenido) this.contenido = {}
		if (typeof datos === 'object' && datos !== null) {
			for (const key in datos) {
				this.contenido[key] = datos[key]
			}
		} else if (typeof datos === 'string') {
			if ('texto' in this.contenido) this.contenido['texto'] = datos
		}
	}
}