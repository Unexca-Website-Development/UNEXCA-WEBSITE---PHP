import BloqueBaseUI from '../componentes/BloqueBaseUI.js'
import EditorControlador from '../../controladores/EditorControlador.js'
import { administradorEventos } from '../../utilidades/AdministradorEventos.js'

class RenderizadorBloquesEstaticosUI {
	constructor(contenedor) {
		this.controlador = new EditorControlador()
		this.contenedor = contenedor
		this.elementos = []
	}

	async renderizar() {
		this.contenedor.innerHTML = ''
		this.elementos = []

		const bloquesUI = this.controlador.convertirParaUI(this.controlador.modelo.cabecera || [])

		for (const bloqueAdaptado of bloquesUI) {
			const bloqueUI = new BloqueBaseUI(bloqueAdaptado, false)
			const elemento = await bloqueUI.renderizar()
			this.contenedor.appendChild(elemento)
			this.elementos.push(bloqueUI)
		}

		return this.contenedor
	}

	obtenerElementos() {
		return this.elementos
	}
}

class RenderizadorBloquesDinamicosUI {
	constructor(contenedor) {
		this.controlador = new EditorControlador()
		this.contenedor = contenedor
		this.elementos = []
		this.bloquesMap = new Map()

		administradorEventos.suscrito('bloquesActualizados', (bloquesUI) => {
			this.sincronizarDOM(bloquesUI)
		})
	}

	async sincronizarDOM(bloquesUI) {
		const idsNuevos = bloquesUI.map(b => b.id)

		// 1. Agregar o reordenar bloques existentes
		for (let i = 0; i < bloquesUI.length; i++) {
			const bloqueAdaptado = bloquesUI[i]
			let bloqueUI

			if (!this.bloquesMap.has(bloqueAdaptado.id)) {
				bloqueUI = new BloqueBaseUI(bloqueAdaptado)
				const elemento = await bloqueUI.renderizar()
				this.bloquesMap.set(bloqueAdaptado.id, bloqueUI)
				this.contenedor.insertBefore(elemento, this.contenedor.children[i] || null)
			} else {
				bloqueUI = this.bloquesMap.get(bloqueAdaptado.id)
				const nodoActual = bloqueUI.elemento
				if (this.contenedor.children[i] !== nodoActual) {
					this.contenedor.insertBefore(nodoActual, this.contenedor.children[i] || null)
				}
			}
		}

		// 2. Detectar y eliminar bloques que ya no existen
		for (const [id, bloqueUI] of this.bloquesMap) {
			if (!idsNuevos.includes(id)) {
				if (bloqueUI.elemento.parentNode) {
					bloqueUI.elemento.parentNode.removeChild(bloqueUI.elemento)
				}
				this.bloquesMap.delete(id)
			}
		}

		// 3. Reconstruir this.elementos en orden correcto
		this.elementos = bloquesUI.map(b => this.bloquesMap.get(b.id))
	}

	obtenerElementos() {
		return this.elementos
	}
}

export { RenderizadorBloquesEstaticosUI, RenderizadorBloquesDinamicosUI }
