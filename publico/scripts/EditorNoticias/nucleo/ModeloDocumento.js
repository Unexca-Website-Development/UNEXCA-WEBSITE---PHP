import { BloqueTitulo } from '../bloques/BloqueTitulo.js'
import { BloqueFechas } from '../bloques/BloqueFechas.js'
import { BloqueParrafo } from '../bloques/BloqueParrafo.js'
import { BloqueImagen } from '../bloques/BloqueImagen.js'
import { BloqueCita } from '../bloques/BloqueCita.js'
import { BloqueLista } from '../bloques/BloqueLista.js'
import { BloqueSubtitulo } from '../bloques/BloqueSubtitulo.js'
import BloqueBase from '../bloques/BloqueBase.js'

export default class ModeloDocumento {
	constructor() {
		this.estado = 'borrador'
		this.cabecera = {
			titulo: new BloqueTitulo('Título Principal'),
			fechas: new BloqueFechas('Información de la noticia'),
			parrafo: new BloqueParrafo('Descripción de la noticia'),
			imagen: new BloqueImagen('Imagen principal')
		}
		this.bloques = []
	}

	agregarBloque(bloque, indice = null) {
		if (!(bloque instanceof BloqueBase)) throw new Error('Debe agregarse un bloque que extienda BloqueBase')
		if (indice === null || indice >= this.bloques.length) this.bloques.push(bloque)
		else if (indice < 0) this.bloques.unshift(bloque)
		else this.bloques.splice(indice, 0, bloque)
	}

	eliminarBloquePorId(id) {
		const idx = this.bloques.findIndex(b => b.id === id)
		if (idx !== -1) this.bloques.splice(idx, 1)
	}

	moverBloque(id, nuevaPosicion) {
		const idx = this.bloques.findIndex(b => b.id === id)
		if (idx === -1) return
		const [bloque] = this.bloques.splice(idx, 1)
		const destino = Math.min(Math.max(nuevaPosicion, 0), this.bloques.length)
		this.bloques.splice(destino, 0, bloque)
	}

	establecerEstado(nuevoEstado) {
		this.estado = nuevoEstado
	}

	obtenerDatos() {
		return {
			estado: this.estado,
			cabecera: {
				titulo: this.cabecera.titulo.obtenerDatos(),
				fechas: this.cabecera.fechas.obtenerDatos(),
				parrafo: this.cabecera.parrafo.obtenerDatos(),
				imagen: this.cabecera.imagen.obtenerDatos()
			},
			bloques: this.bloques.map(b => b.obtenerDatos())
		}
	}

    cargarDatos(datos) {
        if (typeof datos !== 'object' || datos === null) return
        this.estado = datos.estado || this.estado

        if (datos.cabecera) {
            const c = datos.cabecera
            if (c.titulo) this.cabecera.titulo.asignar(c.titulo.contenido || {})
            if (c.fechas) this.cabecera.fechas.asignar(c.fechas.contenido || {})
            if (c.parrafo) this.cabecera.parrafo.asignar(c.parrafo.contenido || {})
            if (c.imagen) this.cabecera.imagen.asignar(c.imagen.contenido || {})
        }

        if (Array.isArray(datos.bloques)) {
            const clasesBloques = {
                parrafo: BloqueParrafo,
                subtitulo: BloqueSubtitulo,
                imagen: BloqueImagen,
                cita: BloqueCita,
                lista: BloqueLista,
                titulo: BloqueTitulo
            }

            this.bloques = datos.bloques.map(d => {
                const Clase = clasesBloques[d.tipo] || BloqueBase
                const bloque = new Clase(d.texto)
                bloque.asignar(d.contenido || {})
                return bloque
            })
        }
    }
}