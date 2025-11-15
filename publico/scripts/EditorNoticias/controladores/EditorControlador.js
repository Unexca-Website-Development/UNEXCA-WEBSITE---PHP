import ModeloDocumento from '../nucleo/ModeloDocumento.js'
import { administradorEventos } from '../utilidades/AdministradorEventos.js'
import BloqueAdaptadorUI from '../adaptadores/BloqueAdaptadorUI.js'
import BloqueAdaptadorModelo from '../adaptadores/BloqueAdaptadorModelo.js'
import { CONFIG_BLOQUES } from '../config/configBloques.js'

export default class EditorControlador {
	static instancia = null

	constructor() {
		if (EditorControlador.instancia) return EditorControlador.instancia
		this.modelo = new ModeloDocumento()
		EditorControlador.instancia = this
	}

	convertirParaUI(bloques) {
		return bloques.map(b => new BloqueAdaptadorUI(b, CONFIG_BLOQUES).generarConfigUI())
	}

	convertirParaModelo(bloquesUI) {
		return bloquesUI.map(b => new BloqueAdaptadorModelo(b, CONFIG_BLOQUES).generarConfigModelo())
	}

	agregarBloque(tipo, contenido = {}, indice = null) {
		this.modelo.agregarBloque(tipo, contenido, indice)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
	}
	
	eliminarBloque(id) {
		this.modelo.eliminarBloquePorId(id)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
	}

	nuevoDocumento() {
		this.modelo.nuevoDocumento()
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
		administradorEventos.notificar('cabeceraActualizada', this.convertirParaUI(this.modelo.cabecera))
		administradorEventos.notificar('estadoActualizado', this.modelo.estado)
	}

	guardarNoticia() {
		const datos = this.obtenerDatos()
		const payload = JSON.stringify(datos)
		console.log(payload)

		// fetch('/api/noticias/guardar.php', {
		// 		method: 'POST',
		// 		headers: { 'Content-Type': 'application/json' },
		// 		body: payload
		// })
		// .then(r => r.json())
		// .then(resp => {
		// 		console.log(resp)
		// })
	}

	moverBloque(id, nuevaPosicion) {
		this.modelo.moverBloque(id, nuevaPosicion)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
	}

	actualizarBloque(id, contenidoUI) {
		let bloque = this.modelo.cabecera.find(b => b.id === id)
		if (bloque) {
			bloque.asignar(contenidoUI)
			administradorEventos.notificar('cabeceraActualizada', this.convertirParaUI(this.modelo.cabecera))
			return
		}
		bloque = this.modelo.bloques.find(b => b.id === id)
		if (!bloque) return
		bloque.asignar(contenidoUI)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
	}

	moverBloqueRelativo(id, desplazamiento) {
		const idxActual = this.modelo.bloques.findIndex(b => b.id === id)
		if (idxActual === -1) return
		let nuevaPos = idxActual + desplazamiento
		nuevaPos = Math.max(0, Math.min(nuevaPos, this.modelo.bloques.length - 1))
		this.modelo.moverBloque(id, nuevaPos)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
	}

	establecerEstado(estado) {
		this.modelo.establecerEstado(estado)
	}

	obtenerDatos() {
		return this.modelo.obtenerDatos()
	}

	cargarDatos(datosUI) {
		const datosModelo = this.convertirParaModelo(datosUI)
		this.modelo.cargarDatos(datosModelo)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
		administradorEventos.notificar('estadoActualizado', this.modelo.estado)
	}
}