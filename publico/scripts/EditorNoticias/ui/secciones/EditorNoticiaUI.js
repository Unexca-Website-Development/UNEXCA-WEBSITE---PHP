import ContenedorSeccion from '../componentes/ContenedorSeccion.js'
import Contenedor from '../componentes/Contenedor.js'
import BloqueAgregar from '../componentes/BloqueAgregar.js'

export default class EditorNoticiaUI {
	constructor() {
		this.dom = {}
	}

	async renderizar() {
		const editorNoticia = document.createElement('div')
		editorNoticia.className = 'editor-noticia'

		// Sección bloques estáticos
		const seccionEstaticos = new ContenedorSeccion('Titular de la noticia')
		const bloquesEstaticos = new Contenedor('editor-noticia__contenido-bloques -estaticos')
		seccionEstaticos.agregarContenido(bloquesEstaticos.renderizar())

		// Sección bloques dinámicos
		const seccionDinamicos = new ContenedorSeccion('Contenido del artículo')
		const bloquesDinamicos = new Contenedor('editor-noticia__contenido-bloques -dinamicos')

		// Opciones para el menú de agregar bloques
		const opcionesBloques = [
			{ icono: '/imagenes/iconos/icon_h2.svg', texto: 'Subtítulo', tipo: 'subtitulo' },
			{ icono: '/imagenes/iconos/icon_parrafo.svg', texto: 'Párrafo', tipo: 'parrafo' },
			{ icono: '/imagenes/iconos/icon_imagen.svg', texto: 'Imagen', tipo: 'imagen' },
			{ icono: '/imagenes/iconos/icon_cita.svg', texto: 'Cita', tipo: 'cita' },
			{ icono: '/imagenes/iconos/icon_lista.svg', texto: 'Lista', tipo: 'lista' }
		]

		const agregarBloque = new BloqueAgregar(opcionesBloques, 'Agregar bloque', '/imagenes/iconos/icon_mas.svg')

		// Agregar el contenedor de bloques y el botón de agregar a la sección dinámica
		seccionDinamicos.agregarContenido(bloquesDinamicos.renderizar())
		seccionDinamicos.agregarContenido(await agregarBloque.renderizar())

		// Agregar secciones al editor
		editorNoticia.appendChild(await seccionEstaticos.renderizar())
		editorNoticia.appendChild(await seccionDinamicos.renderizar())

		this.dom = {
			editorNoticia,
			seccionEstaticos,
			seccionDinamicos,
			bloquesEstaticos,
			bloquesDinamicos,
			agregarBloque
		}

		return editorNoticia
	}

	obtenerReferencias() {
		return this.dom
	}
}
