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
			const bloqueUI = new BloqueBaseUI(bloqueAdaptado)
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
			this.actualizarBloques(bloquesUI)
		})
	}

	async actualizarBloques(bloquesUI) {
		for (const bloqueAdaptado of bloquesUI) {
			if (!this.bloquesMap.has(bloqueAdaptado.id)) {
				const bloqueUI = new BloqueBaseUI(bloqueAdaptado)
				const elemento = await bloqueUI.renderizar()
				this.contenedor.appendChild(elemento)
				this.elementos.push(bloqueUI)
				this.bloquesMap.set(bloqueAdaptado.id, bloqueUI)
			}
		}
	}

	obtenerElementos() {
		return this.elementos
	}
}

export { RenderizadorBloquesEstaticosUI, RenderizadorBloquesDinamicosUI }
