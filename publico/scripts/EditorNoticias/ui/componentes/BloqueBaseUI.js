import { crearLabelBloque, crearTextareaBloque, crearInputBloque } from '../utilidadesUI.js'
import ControlBloque from './ControlBloque.js'
import EditorControlador from '../../controladores/EditorControlador.js'

export default class BloqueBaseUI {
	constructor(bloqueAdaptado, mostrarControl = true) {
		this.bloque = bloqueAdaptado
		this.mostrarControl = mostrarControl
		this.elemento = null
		this.control = new ControlBloque(this.bloque.id)
		this.controlador = new EditorControlador()
	}

	async renderizar() {
		const contenedor = document.createElement('div')
		contenedor.className = 'editor-noticia__bloque'

		const label = await crearLabelBloque(this.bloque.id, this.bloque.texto, this.bloque.icono)
		contenedor.appendChild(label)

		for (const input of this.bloque.inputs) {
			if (input.tipo === 'file') {
				const campo = crearInputBloque(this.bloque.id, input.key, input.tipo, input.requerido, input.aceptar)
				contenedor.appendChild(campo)
				campo.addEventListener('change', async () => {
					const archivo = campo.files[0]
					if (!archivo) return
					const formData = new FormData()
					formData.append('imagen', archivo)
					const resp = await fetch('/api/subir-imagen.php', { method: 'POST', body: formData })
					const data = await resp.json()
					if (data.url) {
						this.controlador.actualizarBloque(this.bloque.id, { ...this.obtenerContenido(), url: data.url })
					}
				})
			}

			if (input.tipo === 'textarea') {
				const campo = crearTextareaBloque(this.bloque.id, input.key, input.placeholder, input.requerido)
				contenedor.appendChild(campo)
				campo.addEventListener('input', () => {
					this.controlador.actualizarBloque(this.bloque.id, this.obtenerContenido())
				})
			}
		}

		if (this.mostrarControl) {
			const controlUI = await this.control.renderizar()
			contenedor.appendChild(controlUI)
		}

		this.elemento = contenedor
		return contenedor
	}

	obtenerContenido() {
		const data = {}
		const inputs = this.elemento.querySelectorAll('input, textarea')
		inputs.forEach(input => {
			const key = input.getAttribute('data-key')
			if (!key) return
			if (input.type === 'file') return
			data[key] = input.value
		})
		return data
	}
}
