import ContenedorSeccion from '../componentes/ContenedorSeccion.js'
import Contenedor from '../componentes/Contenedor.js'
import BloqueAgregar from '../componentes/BloqueAgregar.js'
import RenderizadorBloquesDinamicosUI from '../renderizador/RenderizarBloquesUI.js'
import CabeceraUI from './CabeceraUI.js'
import { CONFIG_BLOQUES } from '../../config/configBloques.js'
import { CONFIG_RUTAS } from '../../config/configRutas.js'

export default class EditorNoticiaUI {
	constructor() {
		this.dom = {}
	}

	async renderizar() {
		const editorNoticia = document.createElement('div')
		editorNoticia.className = 'editor-noticia'

		const cabecera = new CabeceraUI()
		editorNoticia.appendChild(await cabecera.renderizar())

		const seccionDinamicos = new ContenedorSeccion('Contenido del artículo')
		const contenedorDinamicos = new Contenedor('editor-noticia__contenido-bloques -dinamicos')
		const contenedorDinamicosEl = contenedorDinamicos.renderizar()

		new RenderizadorBloquesDinamicosUI(contenedorDinamicosEl)

		const opcionesBloques = Object.values(CONFIG_BLOQUES).map(bloque => ({
			icono: bloque.ui.icono,
			texto: bloque.texto,
			tipo: bloque.tipo
		}))

		const agregarBloque = new BloqueAgregar(opcionesBloques, 'Agregar bloque', CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.mas)

		seccionDinamicos.agregarContenido(contenedorDinamicosEl)
		seccionDinamicos.agregarContenido(await agregarBloque.renderizar())

		editorNoticia.appendChild(await seccionDinamicos.renderizar())

		this.dom = {
			editorNoticia,
			cabecera,
			seccionDinamicos,
			contenedorDinamicos: contenedorDinamicosEl,
			agregarBloque
		}

		return editorNoticia
	}

	obtenerReferencias() {
		return this.dom
	}
}