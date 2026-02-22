import ModeloDocumento from './ModeloDocumento.js'

const modelo = new ModeloDocumento()

console.log('--- 1. Estado inicial ---')
console.log(JSON.stringify(modelo.obtenerDatos(), null, 2))

console.log('\n--- 2. Asignar campos de cabecera ---')
modelo.titulo_principal = 'Noticia de prueba'
modelo.descripcion_corta = 'Descripción corta de prueba'
modelo.descripcion_imagen = 'Imagen principal de prueba'
modelo.fecha_publicacion = '2025-11-11'
console.log(JSON.stringify(modelo.obtenerDatos(), null, 2))

console.log('\n--- 3. Establecer imagen principal via URL ---')
modelo.establecerImagenPrincipal('https://servidor.com/uploads/imagen1.jpg')
console.log(JSON.stringify(modelo.obtenerDatos(), null, 2))

console.log('\n--- 4. Agregar bloques al final ---')
modelo.agregarBloque('parrafo', { texto: 'Primer párrafo' })
modelo.agregarBloque('subtitulo', { texto: 'Subtítulo de sección' })
modelo.agregarBloque('cita', { texto: 'Texto de la cita', autor: 'Autor' })
modelo.agregarBloque('lista', { items: ['Elemento 1', 'Elemento 2', 'Elemento 3'] })
modelo.agregarBloque('imagen', { url: 'https://servidor.com/uploads/imagen2.jpg', descripcion: 'Segunda imagen' })
console.log(JSON.stringify(modelo.obtenerDatos(), null, 2))

console.log('\n--- 5. Agregar bloque en posicion 0 (al inicio) ---')
modelo.agregarBloque('titulo', { texto: 'Título insertado al inicio' }, 0)
console.log(JSON.stringify(modelo.bloques.map(b => b.obtenerDatos()), null, 2))

console.log('\n--- 6. Agregar bloque en posicion 2 (en medio) ---')
modelo.agregarBloque('parrafo', { texto: 'Párrafo insertado en posición 2' }, 2)
console.log(JSON.stringify(modelo.bloques.map(b => b.obtenerDatos()), null, 2))

console.log('\n--- 7. Mover bloque: el ultimo al inicio ---')
const idUltimo = modelo.bloques[modelo.bloques.length - 1].id
modelo.moverBloque(idUltimo, 0)
console.log(JSON.stringify(modelo.bloques.map(b => b.obtenerDatos()), null, 2))

console.log('\n--- 8. Mover bloque: id inexistente (no debe romper) ---')
modelo.moverBloque('id_que_no_existe', 0)
console.log('Sin cambios, bloques:', modelo.bloques.length)

console.log('\n--- 9. Eliminar bloque por id ---')
const idEliminar = modelo.bloques[1].id
modelo.eliminarBloquePorId(idEliminar)
console.log(JSON.stringify(modelo.bloques.map(b => b.obtenerDatos()), null, 2))

console.log('\n--- 10. Eliminar bloque con id inexistente (no debe romper) ---')
modelo.eliminarBloquePorId('id_que_no_existe')
console.log('Sin cambios, bloques:', modelo.bloques.length)

console.log('\n--- 11. Cambiar estado ---')
modelo.establecerEstado('publicado')
console.log('Estado:', modelo.estado)

console.log('\n--- 12. obtenerDatos completo antes de serializar ---')
const datos = modelo.obtenerDatos()
console.log(JSON.stringify(datos, null, 2))

console.log('\n--- 13. cargarDatos en nueva instancia ---')
const modelo2 = new ModeloDocumento()
modelo2.cargarDatos(datos)
console.log(JSON.stringify(modelo2.obtenerDatos(), null, 2))

console.log('\n--- 14. cargarDatos con datos invalidos (no debe romper) ---')
const modelo3 = new ModeloDocumento()
modelo3.cargarDatos(null)
modelo3.cargarDatos('string invalido')
modelo3.cargarDatos(123)
console.log('Sin cambios:', JSON.stringify(modelo3.obtenerDatos(), null, 2))

console.log('\n--- 15. nuevoDocumento resetea todo ---')
modelo.nuevoDocumento()
console.log(JSON.stringify(modelo.obtenerDatos(), null, 2))
