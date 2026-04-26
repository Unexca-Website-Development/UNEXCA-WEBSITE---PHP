import { generarId } from '../utilidades/utilidades.js'
import { CONFIG_BLOQUES } from '../config/configBloques.js'

export default class BloqueBase {
	constructor(tipo_bloque) {
		this.tipo_bloque = tipo_bloque
		this.id = generarId(tipo_bloque)
		const config = CONFIG_BLOQUES[tipo_bloque] || {}
		this.contenido = {}
		for (const key in config.campos) {
			this.contenido[key] = config.campos[key]
		}
	}

	obtenerDatos() {
		return {
			tipo_bloque: this.tipo_bloque,
			datos: { ...this.contenido }
		}
	}

	asignar(datos) {
		if (typeof datos === 'object' && datos !== null) {
			// Si el bloque no tenía campos definidos, los tomamos de los datos que llegan
			if (Object.keys(this.contenido).length === 0) {
				this.contenido = { ...datos };
			} else {
				for (const key in this.contenido) {
					if (key in datos) this.contenido[key] = datos[key]
				}
			}
		} else if (typeof datos === 'string') {
			if ('texto' in this.contenido) this.contenido['texto'] = datos
		}
	}
}