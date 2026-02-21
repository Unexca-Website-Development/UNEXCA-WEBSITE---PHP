import BloqueBase from '../bloques/BloqueBase.js'

export default class ModeloDocumento {
	constructor() {
		this.titulo_principal = ''
		this.descripcion_corta = ''
		this.descripcion_imagen = ''
		this.fecha_publicacion = ''
		this.imagen_principal = ''
		this.estado = 'borrador'
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

	establecerImagenPrincipal(url) {
		this.imagen_principal = url
	}

	nuevoDocumento() {
		this.titulo_principal = ''
		this.descripcion_corta = ''
		this.descripcion_imagen = ''
		this.fecha_publicacion = ''
		this.imagen_principal = ''
		this.estado = 'borrador'
		this.bloques = []
	}

	obtenerDatos() {
		return {
			titulo_principal: this.titulo_principal,
			descripcion_corta: this.descripcion_corta,
			descripcion_imagen: this.descripcion_imagen,
			fecha_publicacion: this.fecha_publicacion,
			imagen_principal: this.imagen_principal,
			estado: this.estado,
			bloques: this.bloques.map(b => b.obtenerDatos())
		}
	}

	cargarDatos(datos) {
		if (!datos || typeof datos !== 'object') return
		this.titulo_principal = datos.titulo_principal || ''
		this.descripcion_corta = datos.descripcion_corta || ''
		this.descripcion_imagen = datos.descripcion_imagen || ''
		this.fecha_publicacion = datos.fecha_publicacion || ''
		this.imagen_principal = datos.imagen_principal || ''
		this.estado = datos.estado || 'borrador'
		if (Array.isArray(datos.bloques)) {
			this.bloques = datos.bloques.map(d => {
				const bloque = new BloqueBase(d.tipo_bloque)
				bloque.asignar(d.datos || {})
				return bloque
			})
		}
	}
}