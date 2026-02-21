import EditorControlador from './EditorControlador.js'
import { administradorEventos } from '../utilidades/AdministradorEventos.js'

const editor = new EditorControlador()

administradorEventos.suscrito('bloquesActualizados', datos => {
	console.log('[evento] bloquesActualizados:', datos.map(b => b.tipo))
})
administradorEventos.suscrito('cabeceraActualizada', datos => {
	console.log('[evento] cabeceraActualizada:', JSON.stringify(datos, null, 2))
})
administradorEventos.suscrito('estadoActualizado', datos => {
	console.log('[evento] estadoActualizado:', datos)
})

console.log('\n--- 1. Singleton: misma instancia ---')
const editor2 = new EditorControlador()
console.log('Misma instancia:', editor === editor2)

console.log('\n--- 2. actualizarCabecera campos validos ---')
editor.actualizarCabecera('titulo_principal', 'Noticia de prueba')
editor.actualizarCabecera('descripcion_corta', 'Descripción corta')
editor.actualizarCabecera('fecha_publicacion', '2025-11-11')

console.log('\n--- 3. actualizarCabecera campo invalido (no debe romper, sin evento) ---')
editor.actualizarCabecera('campo_inexistente', 'valor')

console.log('\n--- 4. establecerImagenPrincipal ---')
editor.establecerImagenPrincipal('https://servidor.com/uploads/imagen1.jpg')

console.log('\n--- 5. establecerEstado ---')
editor.establecerEstado('publicado')

console.log('\n--- 6. agregarBloque al final ---')
editor.agregarBloque('parrafo', { texto: 'Primer párrafo' })
editor.agregarBloque('subtitulo', { texto: 'Subtítulo de sección' })
editor.agregarBloque('cita', { texto: 'Texto de la cita', autor: 'Autor' })
editor.agregarBloque('lista', { items: ['Elemento 1', 'Elemento 2'] })
editor.agregarBloque('imagen', { url: 'https://servidor.com/uploads/imagen2.jpg', descripcion: 'Imagen del cuerpo' })

console.log('\n--- 7. agregarBloque al inicio ---')
editor.agregarBloque('titulo', { texto: 'Título al inicio' }, 0)

console.log('\n--- 8. agregarBloque en posicion 2 ---')
editor.agregarBloque('parrafo', { texto: 'Párrafo en posición 2' }, 2)

console.log('\n--- 9. actualizarBloque existente ---')
editor.actualizarBloque(editor.modelo.bloques[0].id, { texto: 'Texto actualizado' })

console.log('\n--- 10. actualizarBloque id inexistente (no debe romper, sin evento) ---')
editor.actualizarBloque('id_falso', { texto: 'nada' })

console.log('\n--- 11. moverBloque ultimo al inicio ---')
editor.moverBloque(editor.modelo.bloques[editor.modelo.bloques.length - 1].id, 0)

console.log('\n--- 12. moverBloqueRelativo +1 desde posicion 0 ---')
const idPos0 = editor.modelo.bloques[0].id
editor.moverBloqueRelativo(idPos0, 1)

console.log('\n--- 13. moverBloqueRelativo fuera de rango desde posicion final (no debe romper, sin evento) ---')
const idUltimo = editor.modelo.bloques[editor.modelo.bloques.length - 1].id
editor.moverBloqueRelativo(idUltimo, 999)

console.log('\n--- 14. moverBloqueRelativo id inexistente (no debe romper, sin evento) ---')
editor.moverBloqueRelativo('id_falso', 1)

console.log('\n--- 15. eliminarBloque ---')
editor.eliminarBloque(editor.modelo.bloques[1].id)

console.log('\n--- 16. eliminarBloque id inexistente (no debe romper, sin evento) ---')
editor.eliminarBloque('id_falso')

console.log('\n--- 17. obtenerDatos completo ---')
console.log(JSON.stringify(editor.obtenerDatos(), null, 2))

console.log('\n--- 18. guardarNoticia ---')
editor.guardarNoticia()

console.log('\n--- 19. cargarDatos ---')
const snapshot = editor.obtenerDatos()
editor.nuevoDocumento()
editor.cargarDatos(snapshot)
console.log(JSON.stringify(editor.obtenerDatos(), null, 2))

console.log('\n--- 20. nuevoDocumento resetea todo ---')
editor.nuevoDocumento()
console.log(JSON.stringify(editor.obtenerDatos(), null, 2))