import { crearLabelBloque, crearTextareaBloque, crearInputBloque } from '../utilidadesUI.js'
import ControlBloque from './ControlBloque.js'

export default class BloqueBaseUI {
	constructor(bloqueAdaptado) {
		this.bloque = bloqueAdaptado
		this.config = {
			placeholder: bloqueAdaptado.placeholder || '',
			requerido: bloqueAdaptado.requerido || false,
			tipoInput: bloqueAdaptado.tipoInput || 'textarea',
			icono: bloqueAdaptado.icono || `/imagenes/iconos/${bloqueAdaptado.tipo}.svg`,
			inputs: bloqueAdaptado.inputs || []
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
			campo = crearInputBloque(this.bloque.id, this.config.requerido)
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
