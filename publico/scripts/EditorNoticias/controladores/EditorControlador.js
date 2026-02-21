import ModeloDocumento from '../nucleo/ModeloDocumento.js'
import { administradorEventos } from '../utilidades/AdministradorEventos.js'
import { bloqueAUI } from '../adaptadores/BloqueAdaptadores.js'
import { CONFIG_BLOQUES } from '../config/configBloques.js'

export default class EditorControlador {
	static instancia = null

	constructor() {
		if (EditorControlador.instancia) return EditorControlador.instancia
		this.modelo = new ModeloDocumento()
		EditorControlador.instancia = this
	}

	_notificarBloques() {
		administradorEventos.notificar('bloquesActualizados', this.modelo.bloques.map(b => bloqueAUI(b, CONFIG_BLOQUES)))
	}

	_notificarCabecera() {
		administradorEventos.notificar('cabeceraActualizada', {
			titulo_principal: this.modelo.titulo_principal,
			descripcion_corta: this.modelo.descripcion_corta,
			descripcion_imagen: this.modelo.descripcion_imagen,
			fecha_publicacion: this.modelo.fecha_publicacion,
			imagen_principal: this.modelo.imagen_principal
		})
	}

	agregarBloque(tipo, contenido = {}, indice = null) {
		this.modelo.agregarBloque(tipo, contenido, indice)
		this._notificarBloques()
	}

	eliminarBloque(id) {
		const antes = this.modelo.bloques.length
		this.modelo.eliminarBloquePorId(id)
		if (this.modelo.bloques.length === antes) return
		this._notificarBloques()
	}

	moverBloque(id, nuevaPosicion) {
		const idx = this.modelo.bloques.findIndex(b => b.id === id)
		if (idx === -1) return
		this.modelo.moverBloque(id, nuevaPosicion)
		this._notificarBloques()
	}

	moverBloqueRelativo(id, desplazamiento) {
		const idx = this.modelo.bloques.findIndex(b => b.id === id)
		if (idx === -1) return
		const nuevaPos = Math.max(0, Math.min(idx + desplazamiento, this.modelo.bloques.length - 1))
		if (nuevaPos === idx) return
		this.modelo.moverBloque(id, nuevaPos)
		this._notificarBloques()
	}

	actualizarBloque(id, contenido) {
		const bloque = this.modelo.bloques.find(b => b.id === id)
		if (!bloque) return
		bloque.asignar(contenido)
		this._notificarBloques()
	}

	actualizarCabecera(campo, valor) {
		if (!(campo in this.modelo)) return
		this.modelo[campo] = valor
		this._notificarCabecera()
	}

	establecerImagenPrincipal(url) {
		this.modelo.establecerImagenPrincipal(url)
		administradorEventos.notificar('cabeceraActualizada', { imagen_principal: url })
	}

	establecerEstado(estado) {
		this.modelo.establecerEstado(estado)
		administradorEventos.notificar('estadoActualizado', this.modelo.estado)
	}

	nuevoDocumento() {
		this.modelo.nuevoDocumento()
		this._notificarBloques()
		this._notificarCabecera()
		administradorEventos.notificar('estadoActualizado', this.modelo.estado)
	}

	cargarDatos(datos) {
		this.modelo.cargarDatos(datos)
		this._notificarBloques()
		this._notificarCabecera()
		administradorEventos.notificar('estadoActualizado', this.modelo.estado)
	}

	guardarNoticia() {
		console.log(JSON.stringify(this.modelo.obtenerDatos(), null, 2))
	}

	obtenerDatos() {
		return this.modelo.obtenerDatos()
	}
}