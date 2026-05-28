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
		contenedor.tabIndex = 0 // Hacerlo enfocable

		contenedor.addEventListener('focusin', () => {
			document.querySelectorAll('.editor-noticia__bloque--focused').forEach(el => {
				el.classList.remove('editor-noticia__bloque--focused')
			})
			contenedor.classList.add('editor-noticia__bloque--focused')
		})

		const label = await crearLabelBloque(this.bloque.id, this.bloque.texto, this.bloque.icono)
		contenedor.appendChild(label)

		for (const input of this.bloque.inputs) {
			if (input.tipo === 'file') {
				const campo = crearInputBloque(this.bloque.id, input.key, input.tipo, input.requerido, input.aceptar)
				contenedor.appendChild(campo)

				// Contenedor de previsualización para bloques dinámicos
				const preview = document.createElement('div')
				preview.className = 'editor-noticia__preview-imagen'
				preview.style.marginTop = '10px'
				preview.innerHTML = '<img src="" style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px; display: none;">'
				contenedor.appendChild(preview)

				campo.addEventListener('change', async () => {
					const archivo = campo.files[0]
					if (!archivo) return
					
					try {
						const formData = new FormData()
						formData.append('imagen', archivo)
						const resp = await fetch('index.php?pagina=admin-subir-imagen-noticia', { method: 'POST', body: formData })
						const data = await resp.json()
						
						if (data.success && (data.url || data.ruta)) {
							const urlFinal = data.url || data.ruta
							this.controlador.actualizarBloque(this.bloque.id, { ...this.obtenerContenido(), url: urlFinal })
						} else {
							alert('Error al subir imagen: ' + (data.error || 'Desconocido'))
							campo.value = ''
						}
					} catch (error) {
						console.error('Error en la subida:', error)
						alert('Error de red al intentar subir la imagen.')
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
		this.sincronizar(this.bloque)
		return contenedor
	}

	sincronizar(bloqueAdaptado) {
		this.bloque = bloqueAdaptado
		if (!this.elemento) return

		const inputs = this.elemento.querySelectorAll('input, textarea')
		inputs.forEach(input => {
			const key = input.getAttribute('data-key')
			if (!key) return
			if (input.type === 'file') {
				// Manejar previsualización si existe el dato de la URL
				const url = this.bloque.contenido?.['url'] || this.bloque.contenido?.['imagen_principal']
				const previewImg = this.elemento.querySelector('.editor-noticia__preview-imagen img')
				
				if (previewImg && url) {
					let finalUrl = url
					if (!finalUrl.startsWith('http') && !finalUrl.startsWith('/') && !finalUrl.startsWith('publico/')) {
						finalUrl = 'publico/imagenes/' + finalUrl
					}
					previewImg.src = finalUrl
					previewImg.style.display = 'block'
				}
				return
			}
			
			const valor = this.bloque.contenido?.[key] ?? ''
			input.value = valor
		})
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
