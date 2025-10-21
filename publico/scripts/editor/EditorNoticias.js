import { BloqueTexto, BloqueLista, BloqueImagen, BloqueCita } from './Bloques.js'

class EditorNoticias {
	constructor(contenedor) {
		this.contenedor = contenedor
		this.bloques = []
		this.fechaCreacion = new Date()
		this.fechaModificacion = null
		this.fechaPublicacion = null
	}

	async agregarBloque(tipo, texto, icono) {
		let bloque
		switch (tipo) {
			case 'subtitulo':
			case 'titulo':
			case 'descripcion':
			case 'parrafo':
				bloque = new BloqueTexto(tipo, texto, icono, this)
				break
			case 'lista':
				bloque = new BloqueLista(tipo, texto, icono, this)
				break
			case 'imagen':
				bloque = new BloqueImagen(tipo, texto, icono, this)
				break
			case 'cita':
				bloque = new BloqueCita(tipo, texto, icono, this)
				break
			default:
				bloque = new BloqueTexto(tipo, texto, icono, this)
		}
		const elemento = await bloque.renderizar()
		this.bloques.push(bloque)
		this.contenedor.appendChild(elemento)
		this.actualizarFechaModificacion()
		return bloque
	}

	obtenerJSON() {
		return {
			fechaCreacion: this.fechaCreacion,
			fechaModificacion: this.fechaModificacion,
			fechaPublicacion: this.fechaPublicacion,
			bloques: this.bloques.map(b => b.obtenerContenido())
		}
	}

	guardarNoticia() {
		this.fechaModificacion = new Date()
		return this.obtenerJSON()
	}

	publicarNoticia() {
		this.fechaPublicacion = new Date()
		this.actualizarFechaModificacion()
		return this.obtenerJSON()
	}

	actualizarFechaModificacion() {
		this.fechaModificacion = new Date()
	}

	async cargarNoticia(data) {
		this.contenedor.innerHTML = ''
		this.bloques = []
		for (const b of data.bloques) {
			const bloque = await this.agregarBloque(b.tipo, b.texto, b.icono)
			if (b.contenido) bloque.asignarContenido(b.contenido)
		}
		this.fechaCreacion = new Date(data.fechaCreacion)
		this.fechaModificacion = new Date(data.fechaModificacion)
		this.fechaPublicacion = data.fechaPublicacion ? new Date(data.fechaPublicacion) : null
	}
};

export {EditorNoticias};