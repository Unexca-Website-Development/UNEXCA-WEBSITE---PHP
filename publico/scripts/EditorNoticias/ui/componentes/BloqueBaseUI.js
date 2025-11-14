import { crearLabelBloque, crearTextareaBloque, crearInputBloque } from '../utilidadesUI.js'
import ControlBloque from './ControlBloque.js'
import EditorControlador from '../../controladores/EditorControlador.js'

export default class BloqueBaseUI {
	constructor(bloqueAdaptado) {
		this.bloque = bloqueAdaptado
		this.elemento = null
		this.control = new ControlBloque()
		this.controlador = new EditorControlador()
	}

	async renderizar() {
		const contenedor = document.createElement('div')
		contenedor.className = 'editor-noticia__bloque'

		const label = await crearLabelBloque(this.bloque.id, this.bloque.texto, this.bloque.icono)
		contenedor.appendChild(label)

		for (const input of this.bloque.inputs) {
			let campo = null

			if (input.tipo === 'file') {
				campo = crearInputBloque(this.bloque.id, input.key, input.tipo, input.requerido, input.aceptar)
				contenedor.appendChild(campo)
				campo.addEventListener('change', () => {
					this.controlador.actualizarBloque(this.bloque.id, this.obtenerContenido())
				})
			}

			if (input.tipo === 'textarea') {
				campo = crearTextareaBloque(this.bloque.id, input.key, input.placeholder, input.requerido)
				contenedor.appendChild(campo)
				campo.addEventListener('input', () => {
					this.controlador.actualizarBloque(this.bloque.id, this.obtenerContenido())
				})
			}
			
		}

		const controlUI = await this.control.renderizar()
		contenedor.appendChild(controlUI)

		this.elemento = contenedor
		return contenedor
	}

	obtenerContenido() {
		const data = {}
		const inputs = this.elemento.querySelectorAll('input, textarea')
		inputs.forEach(input => {
			const key = input.getAttribute('data-key')
			if (!key) return
			if (input.type === 'file') {
				data[key] = input.files[0] ? input.files[0].name : ''
			} else {
				data[key] = input.value
			}
		})
		return data
	}
}
