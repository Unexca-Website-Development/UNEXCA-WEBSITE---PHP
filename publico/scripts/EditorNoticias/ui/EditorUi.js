import ContenedorSeccion from './secciones/ContenedorSeccion.js'
import Contenedor from './componentes/Contenedor.js'
import BloqueAgregar from './componentes/BloqueAgregar.js'

export default class EditorUI {
	constructor(contenedorRaiz) {
		this.contenedorRaiz = contenedorRaiz
	}

	async renderizarBase() {
		this.contenedorRaiz.innerHTML = ''

		const principal = document.createElement('div')
		principal.className = 'principal'
		principal.id = 'principal'

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

		principal.appendChild(editorNoticia)
		this.contenedorRaiz.appendChild(principal)

		this.dom = {
			principal,
			editorNoticia,
			seccionEstaticos,
			seccionDinamicos,
			bloquesEstaticos,
			bloquesDinamicos,
			agregarBloque
		}
	}

	obtenerReferencias() {
		return this.dom
	}
}

// Para probar
const contenedor = document.getElementById('editor-principal')
const ui = new EditorUI(contenedor)
ui.renderizarBase()
