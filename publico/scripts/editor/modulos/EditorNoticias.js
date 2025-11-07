import { crearBloque } from '../bloques/ConstructorBloques.js'
import { administradorEventos } from '../patrones/AdministradorEventos.js'

class EditorNoticias {
	constructor(contenedorCabecera, contenedorDinamico) {
		this.contenedorCabecera = contenedorCabecera
		this.contenedorDinamico = contenedorDinamico
		this.bloquesCabecera = []
		this.bloquesDinamicos = []
		this.estado = 'borrador'
		this.fechaCreacion = new Date()
		this.fechaModificacion = null
		this.fechaPublicacion = null
	}

	async inicializarCabecera() {
		const bloquesCabecera = [
			{ tipo: 'fechas', texto: 'Información de la noticia', icono: '/imagenes/iconos/icon_calendario.svg' },
			{ tipo: 'parrafo', texto: 'Título de la noticia', icono: '/imagenes/iconos/icon_h1.svg' },
			{ tipo: 'parrafo', texto: 'Descripción de la noticia', icono: '/imagenes/iconos/icon_descripcion.svg' },
			{ tipo: 'imagen', texto: 'Imagen principal', icono: '/imagenes/iconos/icon_imagen.svg' }
		]

		for (const config of bloquesCabecera) {
			const bloque = crearBloque(config.tipo, config.texto, config.icono, this, false)
			this.bloquesCabecera.push(bloque)
			this.contenedorCabecera.appendChild(await bloque.renderizar())
		}
	}

	async agregarBloque(tipo, texto, icono) {
		const bloque = crearBloque(tipo, texto, icono, this)
		this.bloquesDinamicos.push(bloque)
		this.contenedorDinamico.appendChild(await bloque.renderizar())
		this._notificarModificacion('bloqueAgregado')
		return bloque
	}

	actualizarEstado(nuevoEstado) {
		const permitidos = ['borrador', 'publicado', 'archivado']
		if (!permitidos.includes(nuevoEstado)) {
			console.warn(`Estado inválido: ${nuevoEstado}`)
			return
		}

		if (this.estado === nuevoEstado) return

		this.estado = nuevoEstado
		this.fechaModificacion = new Date()

		if (nuevoEstado === 'publicado' && !this.fechaPublicacion) {
			this.fechaPublicacion = new Date()
		}

		console.log(`🧩 Estado actualizado a: ${nuevoEstado}`)
		administradorEventos.notificar('noticiaModificada', { estado: nuevoEstado })
	}

	obtenerJSON() {
		return {
			estado: this.estado,
			fechas: {
				creacion: this.fechaCreacion,
				modificacion: this.fechaModificacion,
				publicacion: this.fechaPublicacion
			},
			cabecera: Object.fromEntries(this.bloquesCabecera.map(b => [b.tipo, b.obtenerContenido()])),
			bloques: this.bloquesDinamicos.map(b => b.obtenerContenido())
		}
	}

	async cargarNoticia(data) {
		this.contenedorCabecera.innerHTML = ''
		this.contenedorDinamico.innerHTML = ''
		this.bloquesCabecera = []
		this.bloquesDinamicos = []

		await this.inicializarCabecera()

		if (data.estado) this.estado = data.estado
		if (data.fechas) {
			this.fechaCreacion = new Date(data.fechas.creacion)
			this.fechaModificacion = data.fechas.modificacion ? new Date(data.fechas.modificacion) : null
			this.fechaPublicacion = data.fechas.publicacion ? new Date(data.fechas.publicacion) : null
		}

		if (data.cabecera) {
			for (const bloque of this.bloquesCabecera) {
				if (data.cabecera[bloque.tipo]) bloque.asignarContenido(data.cabecera[bloque.tipo])
			}
		}

		if (data.bloques) {
			for (const b of data.bloques) {
				const bloque = await this.agregarBloque(b.tipo, b.texto, b.icono)
				if (b.contenido) bloque.asignarContenido(b.contenido)
			}
		}
	}

	validar() {
		const cabecera = Object.fromEntries(this.bloquesCabecera.map(b => [b.tipo, b.obtenerContenido()]))

		if (!cabecera.parrafo || !cabecera.parrafo.trim()) {
			throw new Error('El título no puede estar vacío.')
		}

		if (!cabecera.descripcion || !cabecera.descripcion.trim()) {
			throw new Error('La descripción no puede estar vacía.')
		}

		if (!cabecera.imagen || !cabecera.imagen.url) {
			throw new Error('Debe haber una imagen principal.')
		}

		if (this.bloquesDinamicos.length === 0) {
			throw new Error('Debe haber al menos un bloque de contenido.')
		}

		return true
	}

	marcarComoEditado() {
		this.fechaModificacion = new Date()
		administradorEventos.notificar('noticiaModificada', { fecha: this.fechaModificacion })
	}

	publicarNoticia() {
		if (this.estado === 'publicado') return
		this.estado = 'publicado'

		if (!this.fechaPublicacion) this.fechaPublicacion = new Date()
		this._notificarModificacion('noticiaPublicada')
	
		return { estado: this.estado, fechaPublicacion: this.fechaPublicacion }
	}

	_notificarModificacion(evento) {
		this.fechaModificacion = new Date()
		administradorEventos.notificar(evento, { fecha: this.fechaModificacion })
	}
}

export { EditorNoticias }
