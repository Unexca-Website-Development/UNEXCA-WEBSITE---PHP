import BloqueBaseUI from '../componentes/BloqueBaseUI.js'
import { administradorEventos } from '../../utilidades/AdministradorEventos.js'

export default class RenderizadorBloquesDinamicosUI {
	constructor(contenedor) {
		this.contenedor = contenedor
		this.elementos = []
		this.bloquesMap = new Map()

		administradorEventos.suscrito('bloquesActualizados', (bloquesUI) => {
			this.sincronizarDOM(bloquesUI)
		})
	}

	async sincronizarDOM(bloquesUI) {
		const idsNuevos = new Set(bloquesUI.map(b => b.id))

		for (let i = 0; i < bloquesUI.length; i++) {
			const bloqueAdaptado = bloquesUI[i]

			if (!this.bloquesMap.has(bloqueAdaptado.id)) {
				const bloqueUI = new BloqueBaseUI(bloqueAdaptado)
				const elemento = await bloqueUI.renderizar()
				this.bloquesMap.set(bloqueAdaptado.id, bloqueUI)
				this.contenedor.insertBefore(elemento, this.contenedor.children[i] || null)
			} else {
				const bloqueUI = this.bloquesMap.get(bloqueAdaptado.id)
				const nodoActual = bloqueUI.elemento
				if (this.contenedor.children[i] !== nodoActual) {
					this.contenedor.insertBefore(nodoActual, this.contenedor.children[i] || null)
				}
			}
		}

		const idsEliminar = []
		for (const id of this.bloquesMap.keys()) {
			if (!idsNuevos.has(id)) idsEliminar.push(id)
		}

		for (const id of idsEliminar) {
			const bloqueUI = this.bloquesMap.get(id)
			if (bloqueUI.elemento.parentNode) {
				bloqueUI.elemento.parentNode.removeChild(bloqueUI.elemento)
			}
			this.bloquesMap.delete(id)
		}

		this.elementos = bloquesUI.map(b => this.bloquesMap.get(b.id))
	}

	obtenerElementos() {
		return this.elementos
	}
}