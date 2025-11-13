import EditorControlador from './EditorControlador.js'
import BloqueAdaptadorModelo from '../adaptadores/BloqueAdaptadorModelo.js'
import { CONFIG_BLOQUES } from '../config/configBloques.js'

console.log('--- INICIO DE PRUEBAS ---')

const editor = new EditorControlador()

console.log('\nPaso 1: Estado inicial')
console.log(editor.obtenerDatos())

console.log('\nPaso 2: Agregar bloques (modelo)')
editor.agregarBloque('titulo',)
editor.agregarBloque('parrafo', { texto: 'Este es un párrafo de prueba' })
console.log(editor.obtenerDatos())

console.log('\nPaso 3: Convertir bloques a formato UI')
const bloquesUI = editor.convertirParaUI(editor.modelo.bloques)
console.log(bloquesUI)

console.log('\nPaso 4: Convertir nuevamente a formato modelo')
const bloquesModelo = bloquesUI.map(b => new BloqueAdaptadorModelo(b, CONFIG_BLOQUES).generarConfigModelo())
console.log(bloquesModelo)

console.log('\nPaso 5: Actualizar bloque desde datos UI')
const primerBloqueUI = bloquesUI[0]
primerBloqueUI.contenido.texto = 'Título modificado desde la UI'
const bloqueModeloActualizado = new BloqueAdaptadorModelo(primerBloqueUI, CONFIG_BLOQUES).generarConfigModelo()
editor.actualizarBloque(bloqueModeloActualizado.id, bloqueModeloActualizado.campos)
console.log(editor.obtenerDatos())

console.log('\nPaso 6: Mover bloque')
editor.moverBloque(editor.modelo.bloques[0].id, 1)
console.log(editor.obtenerDatos())

console.log('\nPaso 7: Eliminar bloque')
editor.eliminarBloque(editor.modelo.bloques[0].id)
console.log(editor.obtenerDatos())

console.log('\nPaso 8: Establecer estado')
editor.establecerEstado({ modo: 'edicion' })
console.log(editor.modelo.estado)

console.log('\nPaso 9: Cargar datos desde UI')
const datosUI = [
	{
		id: 300,
		tipo: 'titulo',
		texto: 'Título nuevo desde UI',
		contenido: { texto: 'Título nuevo desde UI' }
	},
	{
		id: 301,
		tipo: 'parrafo',
		texto: 'Párrafo nuevo desde UI',
		contenido: { texto: 'Texto del párrafo nuevo' }
	}
]

// Convertir los datos UI a formato modelo antes de cargarlos
const datosModelo = datosUI.map(b => new BloqueAdaptadorModelo(b, CONFIG_BLOQUES).generarConfigModelo())
editor.cargarDatos(datosModelo)
console.log(JSON.stringify(editor.obtenerDatos(), null, 2))

console.log('\n--- FIN DE PRUEBAS ---')
