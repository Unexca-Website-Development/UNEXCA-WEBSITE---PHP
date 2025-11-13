import { crearLabelBloque, crearTextareaBloque, crearInputBloque } from '../utilidadesUI.js'
import ControlBloque from './ControlBloque.js'

export default class BloqueBaseUI {
	constructor(bloqueAdaptado) {
		this.bloque = bloqueAdaptado
		this.elemento = null
		this.control = new ControlBloque()
	}

	async renderizar() {
		const contenedor = document.createElement('div')
		contenedor.className = 'editor-noticia__bloque'

		const label = await crearLabelBloque(this.bloque.id, this.bloque.texto, this.bloque.icono)
		contenedor.appendChild(label)

		for (const input of this.bloque.inputs){
			if (input.tipo === 'file'){
				const campo = crearInputBloque(this.bloque.id, input.tipo, input.requerido, input.aceptar)
				contenedor.appendChild(campo)
			}
			if (input.tipo === 'textarea'){
				const campo = crearTextareaBloque(this.bloque.id, input.placeholder, input.requerido)
				contenedor.appendChild(campo)
			}
		}

		const controlUI = await this.control.renderizar()
		contenedor.appendChild(controlUI)

		this.elemento = contenedor
		return contenedor
	}
}