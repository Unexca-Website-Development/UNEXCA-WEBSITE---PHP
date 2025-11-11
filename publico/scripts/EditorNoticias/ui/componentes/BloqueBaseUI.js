import { crearLabelBloque, crearTextareaBloque, crearInputArchivo, crearBoton } from '../utilidadesUI.js'
import ControlBloque from './ControlBloque.js'

export default class BloqueBaseUI {
	constructor(bloque, configuracionUI = {}) {
		this.bloque = bloque
		this.config = {
			placeholder: configuracionUI.placeholder || '',
			requerido: configuracionUI.requerido || false,
			tipoInput: configuracionUI.tipoInput || 'textarea',
			icono: configuracionUI.icono || `/iconos/${bloque.tipo}.svg`
		}
		this.elemento = null
		this.control = new ControlBloque()
	}

	async renderizar() {
		const contenedor = document.createElement('div')
		contenedor.className = 'editor-noticia__bloque'

		const label = await crearLabelBloque(this.bloque.id, this.bloque.texto, this.config.icono)
		contenedor.appendChild(label)

		let campo
		if (this.config.tipoInput === 'file') {
			campo = crearInputArchivo(this.bloque.id, this.config.requerido)
		} else {
			campo = crearTextareaBloque(this.bloque.id, this.config.placeholder, this.config.requerido)
		}
		contenedor.appendChild(campo)

		const controlUI = await this.control.renderizar()
		contenedor.appendChild(controlUI)

		this.elemento = contenedor
		return contenedor
	}
}
