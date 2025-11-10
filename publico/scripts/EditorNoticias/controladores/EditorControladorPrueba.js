import EditorControlador from './EditorControlador.js'
import { BloqueParrafo } from '../bloques/BloqueParrafo.js'
import { BloqueTitulo } from '../bloques/BloqueTitulo.js'
import { administradorEventos } from '../utilidades/AdministradorEventos.js'

const editor = new EditorControlador()

administradorEventos.suscribir('bloquesActualizados', bloques => {
	console.log('Bloques actualizados:', bloques.map(b => b.obtenerDatos()))
})

administradorEventos.suscribir('estadoActualizado', estado => {
	console.log('Estado actual del documento:', estado)
})

// Agregar bloques
const bloque1 = new BloqueParrafo('Primer párrafo de prueba')
editor.agregarBloque(bloque1)

const bloque2 = new BloqueTitulo('Subtítulo de sección')
editor.agregarBloque(bloque2)

// Actualizar un bloque
editor.actualizarBloque(bloque1.id, { texto: 'Primer párrafo actualizado' })

// Mover un bloque
editor.moverBloque(bloque2.id, 0)

// Cambiar estado
editor.establecerEstado('publicado')

// Eliminar un bloque
editor.eliminarBloque(bloque1.id)

// Obtener datos completos
console.log('Datos finales del documento:', editor.obtenerDatos())
