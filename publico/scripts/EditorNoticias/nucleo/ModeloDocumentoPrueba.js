import BloqueBase from '../bloques/BloqueBase.js'

export default class ModeloDocumento {
    constructor() {
        this.estado = 'borrador'
        this.cabecera = {
            titulo: new BloqueBase('titulo'),
            fechas: new BloqueBase('fechas'),
            parrafo: new BloqueBase('parrafo'),
            imagen: new BloqueBase('imagen')
        }
        this.bloques = []
    }

    agregarBloque(tipo, contenido = {}, indice = null) {
        const bloque = new BloqueBase(tipo)
        bloque.asignar(contenido)

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
            cabecera: Object.fromEntries(
                Object.entries(this.cabecera).map(([k, v]) => [k, v.obtenerDatos()])
            ),
            bloques: this.bloques.map(b => b.obtenerDatos())
        }
    }

    cargarDatos(datos) {
        if (!datos || typeof datos !== 'object') return
        this.estado = datos.estado || this.estado

        if (datos.cabecera) {
            for (const key in datos.cabecera) {
                if (this.cabecera[key]) this.cabecera[key].asignar(datos.cabecera[key].contenido || {})
            }
        }

        if (Array.isArray(datos.bloques)) {
            this.bloques = datos.bloques.map(d => {
                const bloque = new BloqueBase(d.tipo)
                bloque.asignar(d.contenido || {})
                return bloque
            })
        }
    }
}


// ----------------------- PRUEBA -----------------------

const prueba = new ModeloDocumento()

console.log('--- Estado inicial ---')
console.log(prueba.obtenerDatos())

prueba.cabecera.titulo.asignar({ texto: 'Título de prueba' })
prueba.cabecera.fechas.asignar({ creacion: '2025-11-09', modificacion: '2025-11-10', publicacion: '2025-11-11' })
prueba.cabecera.parrafo.asignar({ texto: 'Descripción de la noticia de prueba' })
prueba.cabecera.imagen.asignar({ archivo: 'imagen1.jpg', descripcion: 'Imagen principal' })

console.log('\n--- Después de asignar datos a cabecera ---')
console.log(prueba.obtenerDatos())

// Agregar bloques
prueba.agregarBloque('parrafo', { texto: 'Primer párrafo de prueba' })
prueba.agregarBloque('subtitulo', { texto: 'Subtítulo de prueba' })
prueba.agregarBloque('parrafo', { texto: 'Segundo párrafo de prueba' })
prueba.agregarBloque('cita', { texto: 'Esta es una cita de ejemplo', autor: 'Autor de la cita' })
prueba.agregarBloque('lista', { items: ['Elemento 1', 'Elemento 2', 'Elemento 3'] })
prueba.agregarBloque('imagen', { archivo: 'imagen2.jpg', descripcion: 'Otra imagen de prueba' })
prueba.agregarBloque('titulo', { texto: 'Subtítulo de sección' })

console.log('\n--- Después de agregar bloques ---')
console.log(prueba.obtenerDatos().bloques)

// Mover bloque 3 al inicio
const bloqueAMover = prueba.bloques[2]
prueba.moverBloque(bloqueAMover.id, 0)
console.log('\n--- Después de mover el tercer bloque al inicio ---')
console.log(prueba.obtenerDatos().bloques)

// Eliminar bloque 2
const bloqueAEliminar = prueba.bloques[2]
prueba.eliminarBloquePorId(bloqueAEliminar.id)
console.log('\n--- Después de eliminar el bloque 2 ---')
console.log(prueba.obtenerDatos().bloques)

// Cambiar estado
prueba.establecerEstado('publicado')
console.log('\n--- Estado cambiado ---')
console.log(prueba.estado)

// Serializar datos
const datosGuardados = prueba.obtenerDatos()
console.log('\n--- Datos serializados ---')
console.log(JSON.stringify(datosGuardados, null, 2))

// Crear nueva instancia y cargar datos
const nuevaInstancia = new ModeloDocumento()
nuevaInstancia.cargarDatos(datosGuardados)
console.log('\n--- Nueva instancia cargada ---')
console.log(JSON.stringify(nuevaInstancia.obtenerDatos(), null, 2))