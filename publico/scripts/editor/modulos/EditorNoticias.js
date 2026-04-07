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
		this._emitirEvento('bloqueAgregado')
		return bloque
	}

	validar() {
		// Obtener bloques de cabecera por tipo
		const bloqueTitulo = this.bloquesCabecera.find(b => b.texto === 'Título de la noticia')
		const bloqueDescripcion = this.bloquesCabecera.find(b => b.texto === 'Descripción de la noticia')
		const bloqueImagen = this.bloquesCabecera.find(b => b.tipo === 'imagen')

		if (!bloqueTitulo) throw new Error('No se encontró el bloque de título.')
		const titulo = bloqueTitulo.obtenerContenido()
		if (!titulo.contenido || !titulo.contenido[0] || !titulo.contenido[0].trim()) {
			throw new Error('El título no puede estar vacío.')
		}

		if (!bloqueDescripcion) throw new Error('No se encontró el bloque de descripción.')
		const descripcion = bloqueDescripcion.obtenerContenido()
		if (!descripcion.contenido || !descripcion.contenido[0] || !descripcion.contenido[0].trim()) {
			throw new Error('La descripción no puede estar vacía.')
		}

		if (bloqueImagen) {
			const imagen = bloqueImagen.obtenerContenido()
			if (!imagen.contenido || !imagen.contenido[0] || !imagen.contenido[0].trim()) {
				throw new Error('Debe haber una imagen principal.')
			}
		} else {
			throw new Error('No se encontró el bloque de imagen.')
		}

		if (this.bloquesDinamicos.length === 0) {
			throw new Error('Debe haber al menos un bloque de contenido.')
		}

		return true
	}

	publicarNoticia() {
		if (this.estado === 'publicado') return
		this.estado = 'publicado'
		if (!this.fechaPublicacion) this.fechaPublicacion = new Date()
		this._emitirEvento('noticiaPublicada')
	}

	marcarComoEditado() {
		this.fechaModificacion = new Date()
		administradorEventos.notificar('noticiaModificada', { 
			estado: this.estado, 
			fecha: this.fechaModificacion 
		})
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
		try {
			// Limpiar todo
			this.contenedorCabecera.innerHTML = ''
			this.contenedorDinamico.innerHTML = ''
			this.bloquesCabecera = []
			this.bloquesDinamicos = []

			// Reinicializar cabecera
			await this.inicializarCabecera()

			// Cargar estado y fechas
			if (data.estado) this.estado = data.estado
			if (data.fechas) {
				this.fechaCreacion = data.fechas.creacion ? new Date(data.fechas.creacion) : new Date()
				this.fechaModificacion = data.fechas.modificacion ? new Date(data.fechas.modificacion) : null
				this.fechaPublicacion = data.fechas.publicacion ? new Date(data.fechas.publicacion) : null
			}

			// Cargar cabecera - buscar por texto o tipo
			if (data.cabecera) {
				for (const bloque of this.bloquesCabecera) {
					// Buscar por tipo primero
					if (data.cabecera[bloque.tipo]) {
						const contenido = data.cabecera[bloque.tipo]
						// Si viene como objeto con contenido, usar contenido, sino usar directamente
						if (contenido && typeof contenido === 'object' && contenido.contenido) {
							bloque.asignarContenido(contenido.contenido)
						} else if (Array.isArray(contenido)) {
							bloque.asignarContenido(contenido)
						}
					}
				}
			}

			// Cargar bloques dinámicos
			if (data.bloques && Array.isArray(data.bloques)) {
				for (const b of data.bloques) {
					const tipo = b.tipo || 'parrafo'
					const texto = b.texto || 'Contenido'
					const icono = b.icono || '/imagenes/iconos/icon_parrafo.svg'
					
					const bloque = await this.agregarBloque(tipo, texto, icono)
					
					// Asignar contenido si existe
					if (b.contenido && Array.isArray(b.contenido)) {
						bloque.asignarContenido(b.contenido)
					}
				}
			}

			this._emitirEvento('noticiaCargada')
		} catch (error) {
			console.error('Error al cargar noticia:', error)
			throw error
		}
	}

	_emitirEvento(evento, datos = {}) {
		administradorEventos.notificar(evento, { 
			estado: this.estado, 
			fechaModificacion: this.fechaModificacion,
			...datos 
		})
	}
}

export { EditorNoticias }
