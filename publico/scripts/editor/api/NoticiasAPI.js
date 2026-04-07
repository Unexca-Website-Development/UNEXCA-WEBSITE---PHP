/**
 * Módulo para comunicación con la API PHP del editor de noticias
 * Preparado para recibir y enviar JSON
 */

class NoticiasAPI {
	constructor() {
		// URL base del endpoint - se configurará cuando esté listo el endpoint PHP
		this.baseURL = '/api/noticias'
	}

	/**
	 * Guardar noticia (crear nueva o actualizar existente)
	 * @param {Object} jsonData - JSON generado por el editor
	 * @returns {Promise<Object>} Respuesta del servidor
	 */
	async guardarNoticia(jsonData) {
		try {
			const response = await fetch(this.baseURL, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(jsonData)
			})

			if (!response.ok) {
				const error = await response.json().catch(() => ({ message: 'Error desconocido' }))
				throw new Error(error.message || `Error ${response.status}`)
			}

			return await response.json()
		} catch (error) {
			console.error('Error al guardar noticia:', error)
			throw error
		}
	}

	/**
	 * Publicar noticia
	 * @param {Object} jsonData - JSON generado por el editor
	 * @returns {Promise<Object>} Respuesta del servidor
	 */
	async publicarNoticia(jsonData) {
		try {
			const response = await fetch(`${this.baseURL}/publicar`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(jsonData)
			})

			if (!response.ok) {
				const error = await response.json().catch(() => ({ message: 'Error desconocido' }))
				throw new Error(error.message || `Error ${response.status}`)
			}

			return await response.json()
		} catch (error) {
			console.error('Error al publicar noticia:', error)
			throw error
		}
	}

	/**
	 * Cargar noticia por ID
	 * @param {number} noticiaId - ID de la noticia
	 * @returns {Promise<Object>} JSON de la noticia
	 */
	async cargarNoticia(noticiaId) {
		try {
			const response = await fetch(`${this.baseURL}/${noticiaId}`, {
				method: 'GET',
				headers: {
					'Content-Type': 'application/json',
				}
			})

			if (!response.ok) {
				const error = await response.json().catch(() => ({ message: 'Error desconocido' }))
				throw new Error(error.message || `Error ${response.status}`)
			}

			const data = await response.json()
			// Transformar respuesta PHP a formato del editor si es necesario
			return this._transformarRespuesta(data)
		} catch (error) {
			console.error('Error al cargar noticia:', error)
			throw error
		}
	}

	/**
	 * Eliminar noticia
	 * @param {number} noticiaId - ID de la noticia
	 * @returns {Promise<Object>} Respuesta del servidor
	 */
	async eliminarNoticia(noticiaId) {
		try {
			const response = await fetch(`${this.baseURL}/${noticiaId}`, {
				method: 'DELETE',
				headers: {
					'Content-Type': 'application/json',
				}
			})

			if (!response.ok) {
				const error = await response.json().catch(() => ({ message: 'Error desconocido' }))
				throw new Error(error.message || `Error ${response.status}`)
			}

			return await response.json()
		} catch (error) {
			console.error('Error al eliminar noticia:', error)
			throw error
		}
	}

	/**
	 * Listar noticias recientes
	 * @param {number} limite - Número de noticias a obtener
	 * @returns {Promise<Array>} Lista de noticias
	 */
	async listarNoticias(limite = 10) {
		try {
			const response = await fetch(`${this.baseURL}?limite=${limite}`, {
				method: 'GET',
				headers: {
					'Content-Type': 'application/json',
				}
			})

			if (!response.ok) {
				const error = await response.json().catch(() => ({ message: 'Error desconocido' }))
				throw new Error(error.message || `Error ${response.status}`)
			}

			return await response.json()
		} catch (error) {
			console.error('Error al listar noticias:', error)
			throw error
		}
	}

	/**
	 * Transformar respuesta de PHP al formato esperado por el editor
	 * @param {Object} data - Datos de respuesta de PHP
	 * @returns {Object} JSON en formato del editor
	 */
	_transformarRespuesta(data) {
		// Si PHP devuelve { noticia: {...}, bloques: [...] }
		// Transformarlo a { estado, fechas, cabecera, bloques }
		
		if (data.noticia && data.bloques) {
			const noticia = data.noticia
			const bloques = data.bloques

			// Mapear cabecera desde noticia
			const cabecera = {}
			if (noticia.titulo) {
				cabecera.parrafo = {
					tipo: 'parrafo',
					texto: 'Título de la noticia',
					contenido: [noticia.titulo]
				}
			}
			if (noticia.descripcion) {
				cabecera.parrafo = {
					tipo: 'parrafo',
					texto: 'Descripción de la noticia',
					contenido: [noticia.descripcion]
				}
			}
			if (noticia.imagen_principal) {
				cabecera.imagen = {
					tipo: 'imagen',
					texto: 'Imagen principal',
					contenido: [noticia.imagen_principal, '']
				}
			}

			// Transformar bloques
			const bloquesTransformados = bloques.map(bloque => {
				const datos = typeof bloque.datos === 'string' 
					? JSON.parse(bloque.datos) 
					: bloque.datos

				return {
					id: bloque.contenido_id || bloque.id,
					tipo: bloque.tipo_bloque || bloque.tipo,
					texto: this._obtenerTextoPorTipo(bloque.tipo_bloque || bloque.tipo),
					icono: this._obtenerIconoPorTipo(bloque.tipo_bloque || bloque.tipo),
					contenido: Array.isArray(datos) ? datos : (datos.contenido || [datos])
				}
			})

			return {
				estado: noticia.estado || 'borrador',
				fechas: {
					creacion: noticia.fecha_creacion,
					modificacion: noticia.fecha_modificacion,
					publicacion: noticia.fecha_publicacion
				},
				cabecera: cabecera,
				bloques: bloquesTransformados
			}
		}

		// Si ya viene en formato del editor, devolverlo tal cual
		return data
	}

	/**
	 * Obtener texto por tipo de bloque
	 */
	_obtenerTextoPorTipo(tipo) {
		const textos = {
			'parrafo': 'Párrafo',
			'subtitulo': 'Subtítulo',
			'imagen': 'Imagen',
			'lista': 'Lista',
			'cita': 'Cita',
			'fechas': 'Información de la noticia'
		}
		return textos[tipo] || tipo
	}

	/**
	 * Obtener icono por tipo de bloque
	 */
	_obtenerIconoPorTipo(tipo) {
		const iconos = {
			'parrafo': '/imagenes/iconos/icon_parrafo.svg',
			'subtitulo': '/imagenes/iconos/icon_h2.svg',
			'imagen': '/imagenes/iconos/icon_imagen.svg',
			'lista': '/imagenes/iconos/icon_lista.svg',
			'cita': '/imagenes/iconos/icon_cita.svg',
			'fechas': '/imagenes/iconos/icon_calendario.svg'
		}
		return iconos[tipo] || '/imagenes/iconos/icon_parrafo.svg'
	}
}

export const noticiasAPI = new NoticiasAPI()

