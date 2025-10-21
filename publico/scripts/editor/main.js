<<<<<<< HEAD
import { EditorNoticias } from './EditorNoticias.js'
import { normalizarTexto } from './utilidades.js'

document.addEventListener('DOMContentLoaded', async () => {
	const contenedorDinamico = document.querySelector('.editor-noticia__contenido-bloques.-dinamicos')
	const contenedorCabecera = document.querySelector('.editor-noticia__contenido-bloques.-estaticos')

	const editor = new EditorNoticias(contenedorCabecera, contenedorDinamico)
	await editor.inicializarCabecera()
=======
// editarNoticias.js (archivo de entrada para la página de edición)
import { EditorNoticias } from './EditorNoticias.js'
import { normalizarTexto } from './utilidades.js'

document.addEventListener('DOMContentLoaded', () => {
	const contenedorBloques = document.querySelector('.editor-noticia__contenido-bloques.-dinamicos')
	const editor = new EditorNoticias(contenedorBloques)
>>>>>>> c30902c (Implementación del nuevo editor de noticias con bloques dinámicos)

	const botones = document.querySelectorAll('.agregar-bloque__opcion')
	botones.forEach(boton => {
		boton.addEventListener('click', async () => {
			const tipo = normalizarTexto(boton.textContent.trim())
			let iconoRuta

			switch (tipo) {
				case 'subtitulo':
					iconoRuta = '/imagenes/iconos/icon_h2.svg'
					break
				case 'parrafo':
					iconoRuta = '/imagenes/iconos/icon_parrafo.svg'
					break
				case 'imagen':
					iconoRuta = '/imagenes/iconos/icon_imagen.svg'
					break
				case 'cita':
					iconoRuta = '/imagenes/iconos/icon_cita.svg'
					break
				case 'lista':
					iconoRuta = '/imagenes/iconos/icon_lista.svg'
					break
				default:
					return
			}

<<<<<<< HEAD
			await editor.agregarBloque(tipo, boton.textContent.trim(), iconoRuta, true)
		})
	})

=======
			await editor.agregarBloque(tipo, boton.textContent.trim(), iconoRuta)
		})
	})

	// === BLOQUE DE PRUEBA TEMPORAL ===
>>>>>>> c30902c (Implementación del nuevo editor de noticias con bloques dinámicos)
	window.editorDebug = editor

	console.log('🧩 EditorNoticias inicializado:', editor)

	document.addEventListener('keydown', async e => {
		if (e.key === 'g') {
<<<<<<< HEAD
			const data = editor.obtenerJSON()
			console.log('💾 JSON guardado:', data)
			window.ultimoGuardado = data
=======
			const data = editor.guardarNoticia()
			console.log('💾 JSON guardado:', data)
>>>>>>> c30902c (Implementación del nuevo editor de noticias con bloques dinámicos)
		}
		if (e.key === 'c') {
			await editor.cargarNoticia(window.ultimoGuardado || {})
			console.log('🔁 Noticia recargada desde JSON')
		}
		if (e.key === 'p') {
			const publicada = editor.publicarNoticia()
			console.log('🚀 Publicación:', publicada)
		}
	})
<<<<<<< HEAD
})
=======

})
>>>>>>> c30902c (Implementación del nuevo editor de noticias con bloques dinámicos)
