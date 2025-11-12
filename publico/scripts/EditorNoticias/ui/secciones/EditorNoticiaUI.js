import ContenedorSeccion from '../componentes/ContenedorSeccion.js'
import Contenedor from '../componentes/Contenedor.js'
import BloqueAgregar from '../componentes/BloqueAgregar.js'
import { RenderizadorBloquesEstaticosUI } from '../renderizador/RenderizarBloquesUI.js'

export default class EditorNoticiaUI {
	constructor() {
		this.dom = {}
	}

	async renderizar() {
		const editorNoticia = document.createElement('div')
		editorNoticia.className = 'editor-noticia'

		// Sección bloques estáticos
		const seccionEstaticos = new ContenedorSeccion('Titular de la noticia')
		const contenedorEstaticos = new Contenedor('editor-noticia__contenido-bloques -estaticos')
		const renderBloquesEstaticos = new RenderizadorBloquesEstaticosUI(contenedorEstaticos.renderizar())
		const elementosEstaticos = await renderBloquesEstaticos.renderizar()
		seccionEstaticos.agregarContenido(elementosEstaticos)

		// Sección bloques dinámicos
		const seccionDinamicos = new ContenedorSeccion('Contenido del artículo')
		const contenedorDinamicos = new Contenedor('editor-noticia__contenido-bloques -dinamicos')
		const renderBloquesDinamicos = new RenderizadorBloquesEstaticosUI(contenedorDinamicos.renderizar()) 
		const elementosDinamicos = await renderBloquesDinamicos.renderizar()

		// Opciones para el menú de agregar bloques
		const opcionesBloques = [
			{ icono: '/imagenes/iconos/icon_h2.svg', texto: 'Subtítulo', tipo: 'subtitulo' },
			{ icono: '/imagenes/iconos/icon_parrafo.svg', texto: 'Párrafo', tipo: 'parrafo' },
			{ icono: '/imagenes/iconos/icon_imagen.svg', texto: 'Imagen', tipo: 'imagen' },
			{ icono: '/imagenes/iconos/icon_cita.svg', texto: 'Cita', tipo: 'cita' },
			{ icono: '/imagenes/iconos/icon_lista.svg', texto: 'Lista', tipo: 'lista' }
		]

		const agregarBloque = new BloqueAgregar(opcionesBloques, 'Agregar bloque', '/imagenes/iconos/icon_mas.svg')
		const elementoAgregar = await agregarBloque.renderizar()

		// Agregar el contenedor de bloques y el botón de agregar a la sección dinámica
		seccionDinamicos.agregarContenido(elementosDinamicos)
		seccionDinamicos.agregarContenido(elementoAgregar)

		// Agregar secciones al editor
		editorNoticia.appendChild(await seccionEstaticos.renderizar())
		editorNoticia.appendChild(await seccionDinamicos.renderizar())

		this.dom = {
			editorNoticia,
			seccionEstaticos,
			seccionDinamicos,
			contenedorEstaticos,
			contenedorDinamicos,
			agregarBloque
		}

		return editorNoticia
	}

	obtenerReferencias() {
		return this.dom
	}
}
