import { generarId } from '../utilidades/utilidades.js'
import { CONFIG_BLOQUES } from '../config/configBloques.js'

export default class BloqueBase {
	constructor(tipo) {
		this.tipo = tipo
		this.id = generarId(tipo)
		const config = CONFIG_BLOQUES[tipo] || {}
		this.contenido = {}
		for (const key in config.campos) {
			this.contenido[key] = config.campos[key]
		}
	}

	obtenerDatos() {
		return {
			tipo_bloque: this.tipo,
			datos: { ...this.contenido }
		}
	}

	asignar(datos) {
		if (typeof datos === 'object' && datos !== null) {
			for (const key in this.contenido) {
				if (key in datos) this.contenido[key] = datos[key]
			}
		} else if (typeof datos === 'string') {
			if ('texto' in this.contenido) this.contenido['texto'] = datos
		}
	}
}