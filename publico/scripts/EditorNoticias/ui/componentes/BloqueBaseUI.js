import { crearLabelBloque, crearTextareaBloque, crearBoton } from '../utilidadesUI.js'
import ControlBloque from './ControlBloque.js'

export default class BloqueBaseUI {
	constructor({ id, tipo, texto = '', placeholder = '', requerido = false }) {
		this.id = id
		this.tipo = tipo
		this.texto = texto
		this.placeholder = placeholder
		this.requerido = requerido
		this.elemento = null
		this.control = new ControlBloque()
	}

	async renderizar() {
		const contenedor = document.createElement('div')
		contenedor.className = 'editor-noticia__bloque'

		const label = await crearLabelBloque(this.id, this.texto, `/iconos/${this.tipo}.svg`)
		contenedor.appendChild(label)

		const textarea = crearTextareaBloque(this.id, this.placeholder, this.requerido)
		contenedor.appendChild(textarea)

		const controlUI = await this.control.renderizar()
		contenedor.appendChild(controlUI)

		this.elemento = contenedor
		return contenedor
	}
}
