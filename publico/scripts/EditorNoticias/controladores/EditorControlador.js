import ModeloDocumento from '../nucleo/ModeloDocumento.js'
import { administradorEventos } from '../utilidades/AdministradorEventos.js'
import BloqueAdaptador from '../adaptadores/BloqueAdaptador.js'
import configBloques from '../config/configBloques.js'

export default class EditorControlador {
	constructor() {
		this.modelo = new ModeloDocumento()
	}

	convertirParaUI(bloques) {
		return bloques.map(b => new BloqueAdaptador(b, configBloques).generarConfigUI())
	}

	agregarBloque(tipo, contenido = {}, indice = null) {
		this.modelo.agregarBloque(tipo, contenido, indice)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
	}

	eliminarBloque(id) {
		this.modelo.eliminarBloquePorId(id)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
	}

	moverBloque(id, nuevaPosicion) {
		this.modelo.moverBloque(id, nuevaPosicion)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
	}

	actualizarBloque(id, contenido) {
		const bloque = this.modelo.bloques.find(b => b.id === id)
		if (!bloque) return
		bloque.asignar(contenido)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
	}

	establecerEstado(estado) {
		this.modelo.establecerEstado(estado)
		administradorEventos.notificar('estadoActualizado', this.modelo.estado)
	}

	obtenerDatos() {
		return this.modelo.obtenerDatos()
	}

	cargarDatos(datos) {
		this.modelo.cargarDatos(datos)
		administradorEventos.notificar('bloquesActualizados', this.convertirParaUI(this.modelo.bloques))
		administradorEventos.notificar('estadoActualizado', this.modelo.estado)
	}
}
