import BloqueBase from '../bloques/BloqueBase.js'

export default class ModeloDocumento {
	constructor() {
		this.estado = 'borrador'
		this.cabecera = [
			new BloqueBase('titulo'),
			new BloqueBase('fechas'),
			new BloqueBase('parrafo'),
			new BloqueBase('imagen')
		]
		this.bloques = []
	}

	agregarBloque(tipo, contenido = {}, indice = null) {
		const bloque = new BloqueBase(tipo)
		bloque.asignar(contenido)

		if (indice === null || indice >= this.bloques.length) this.bloques.push(bloque)
		else if (indice < 0) this.bloques.unshift(bloque)
		else this.bloques.splice(indice, 0, bloque)
	}

	eliminarBloquePorId(id) {
		const idx = this.bloques.findIndex(b => b.id === id)
		if (idx !== -1) this.bloques.splice(idx, 1)
	}

	moverBloque(id, nuevaPosicion) {
		const idx = this.bloques.findIndex(b => b.id === id)
		if (idx === -1) return
		const [bloque] = this.bloques.splice(idx, 1)
		const destino = Math.min(Math.max(nuevaPosicion, 0), this.bloques.length)
		this.bloques.splice(destino, 0, bloque)
	}

	establecerEstado(nuevoEstado) {
		this.estado = nuevoEstado
	}

	nuevoDocumento() {
		this.estado = 'borrador'
		this.cabecera = [
			new BloqueBase('titulo'),
			new BloqueBase('fechas'),
			new BloqueBase('parrafo'),
			new BloqueBase('imagen')
		]
		this.bloques = []
	}

	obtenerDatos() {
		return {
			estado: this.estado,
			cabecera: Object.fromEntries(
				this.cabecera.map(b => [b.tipo, b.obtenerDatos()])
			),
			bloques: this.bloques.map(b => b.obtenerDatos())
		}
	}

	cargarDatos(datos) {
		if (!datos || typeof datos !== 'object') return
		this.estado = datos.estado || this.estado

		if (datos.cabecera) {
			for (const bloque of this.cabecera) {
				const key = bloque.tipo
				if (datos.cabecera[key]) {
					bloque.asignar(datos.cabecera[key].contenido || {})
				}
			}
		}

		if (Array.isArray(datos.bloques)) {
			this.bloques = datos.bloques.map(d => {
				const bloque = new BloqueBase(d.tipo)
				bloque.asignar(d.contenido || {})
				return bloque
			})
		}
	}

	moverBloque(id, nuevaPosicion) {
		const idx = this.bloques.findIndex(b => b.id === id)
		if (idx === -1) return
		const [bloque] = this.bloques.splice(idx, 1)
		const destino = Math.min(Math.max(nuevaPosicion, 0), this.bloques.length)
		this.bloques.splice(destino, 0, bloque)
	}
}
