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

const doc = new ModeloDocumento()

console.log('--- Estado inicial ---')
console.log(doc.obtenerDatos())

doc.establecerEstado('publicado')
console.log('\n--- Estado cambiado ---')
console.log(doc.estado)

// Asignar contenido a la cabecera
doc.cabecera.titulo.asignar({ texto: 'Título de prueba' })
doc.cabecera.fechas.asignar({ creacion: '2025-11-09', modificacion: '2025-11-09', publicacion: '2025-11-10' })
doc.cabecera.parrafo.asignar({ texto: 'Descripción de la noticia de prueba' })
doc.cabecera.imagen.asignar({ archivo: 'imagen.jpg', descripcion: 'Imagen de prueba' })

// Agregar todos los bloques dinámicos con contenido
const bloque1 = new BloqueParrafo('Párrafo')
bloque1.asignar({ texto: 'Primer párrafo de prueba' })

const bloque2 = new BloqueSubtitulo('Subtítulo')
bloque2.asignar({ texto: 'Subtítulo de prueba' })

const bloque3 = new BloqueParrafo('Párrafo')
bloque3.asignar({ texto: 'Segundo párrafo de prueba' })

const bloque4 = new BloqueCita('Cita')
bloque4.asignar({ texto: 'Esta es una cita de ejemplo', autor: 'Autor de la cita' })

const bloque5 = new BloqueLista('Lista')
bloque5.asignar({ items: ['Elemento 1', 'Elemento 2', 'Elemento 3'] })

const bloque6 = new BloqueImagen('Imagen')
bloque6.asignar({ archivo: 'imagen2.jpg', descripcion: 'Otra imagen de prueba' })

const bloque7 = new BloqueTitulo('Título Secundario')
bloque7.asignar({ texto: 'Subtítulo de sección' })

doc.agregarBloque(bloque1)
doc.agregarBloque(bloque2)
doc.agregarBloque(bloque3)
doc.agregarBloque(bloque4)
doc.agregarBloque(bloque5)
doc.agregarBloque(bloque6)
doc.agregarBloque(bloque7)

console.log('\n--- Después de agregar bloques ---')
console.log(doc.obtenerDatos().bloques)

// Mover bloque 3 al inicio
doc.moverBloque(bloque3.id, 0)
console.log('\n--- Después de mover bloque 3 al inicio ---')
console.log(doc.obtenerDatos().bloques)

// Eliminar bloque 2
doc.eliminarBloquePorId(bloque2.id)
console.log('\n--- Después de eliminar bloque 2 ---')
console.log(doc.obtenerDatos().bloques)

// Serializar datos
const datosGuardados = doc.obtenerDatos()
console.log('\n--- Datos guardados (serializados) ---')
console.log(JSON.stringify(datosGuardados, null, 2))

// Crear nueva instancia y cargar datos
const nuevaDoc = new ModeloDocumento()
nuevaDoc.cargarDatos(datosGuardados)
console.log('\n--- Nueva instancia cargada ---')
console.log(JSON.stringify(nuevaDoc.obtenerDatos(), null, 2))