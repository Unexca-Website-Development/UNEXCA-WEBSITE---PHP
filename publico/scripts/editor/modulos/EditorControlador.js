import { administradorEventos } from '../patrones/AdministradorEventos.js'
import { noticiasAPI } from '../api/NoticiasAPI.js'

class EditorControlador {
	constructor(editor) {
		this.editor = editor
		this.ultimoGuardado = null
		this.noticiaId = null // ID de la noticia si está editando una existente
	}

	inicializar() {
		this._suscribirEventos()
	}

	_suscribirEventos() {
		// Eventos del editor
		administradorEventos.suscribir('bloqueAgregado', () => this.marcarEditado())
		// El evento 'noticiaModificada' se emite desde marcarComoEditado(),
		// por lo que no debemos suscribirnos a él aquí para evitar un bucle infinito
		administradorEventos.suscribir('noticiaPublicada', () => {
			this.ultimoGuardado = this.editor.obtenerJSON()
			console.log('Noticia publicada y guardada', this.ultimoGuardado)
		})

		// Eventos del menú lateral
		administradorEventos.suscribir('opcionMenuSeleccionada', (opcion) => {
			switch (opcion) {
				case 'nueva':
					this.nuevaNoticia()
					break
				case 'guardar':
					this.guardarNoticia()
					break
				case 'publicar':
					this.publicarNoticia()
					break
				case 'buscar':
					console.log('Buscador de noticias (pendiente)')
					break
				case 'recientes':
					console.log('Noticias recientes (pendiente)')
					break
				default:
					console.warn(`Opción de menú desconocida: ${opcion}`)
			}
		})
	}

	async guardarNoticia() {
		try {
			this.editor.validar()
			const jsonData = this.editor.obtenerJSON()
			this.ultimoGuardado = jsonData
			
			// TODO: Cuando el endpoint PHP esté listo, descomentar:
			// try {
			// 	const respuesta = await noticiasAPI.guardarNoticia(jsonData)
			// 	this.noticiaId = respuesta.id || this.noticiaId
			// 	console.log('Noticia guardada en servidor:', respuesta)
			// } catch (apiError) {
			// 	console.error('Error al guardar en servidor:', apiError)
			// 	// Guardar en memoria como fallback
			// }
			
			console.log('Noticia guardada (memoria):', jsonData)
		} catch (error) {
			console.error('Error al guardar:', error.message)
			alert(`Error: ${error.message}`)
		}
	}

	async publicarNoticia() {
		try {
			this.editor.validar()
			this.editor.publicarNoticia()
			const jsonData = this.editor.obtenerJSON()
			
			// TODO: Cuando el endpoint PHP esté listo, descomentar:
			// try {
			// 	const respuesta = await noticiasAPI.publicarNoticia(jsonData)
			// 	this.noticiaId = respuesta.id || this.noticiaId
			// 	console.log('Noticia publicada en servidor:', respuesta)
			// } catch (apiError) {
			// 	console.error('Error al publicar en servidor:', apiError)
			// }
			
			console.log('Noticia publicada (memoria):', jsonData)
		} catch (error) {
			console.error('Error al publicar:', error.message)
			alert(`Error: ${error.message}`)
		}
	}

	async nuevaNoticia() {
		try {
			this.editor.estado = 'borrador'
			this.editor.fechaCreacion = new Date()
			this.editor.fechaModificacion = null
			this.editor.fechaPublicacion = null
			this.editor.bloquesCabecera = []
			this.editor.bloquesDinamicos = []
			this.editor.contenedorCabecera.innerHTML = ''
			this.editor.contenedorDinamico.innerHTML = ''
			await this.editor.inicializarCabecera()
			this.ultimoGuardado = null
			console.log('Nueva noticia inicializada')
		} catch (error) {
			console.error('Error al crear nueva noticia:', error)
		}
	}

	marcarEditado() {
		this.editor.marcarComoEditado()
		console.log('Noticia marcada como editada')
	}
}

export { EditorControlador }
