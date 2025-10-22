import { EditorNoticias } from './EditorNoticias.js'
import { normalizarTexto } from './utilidades.js'

document.addEventListener('DOMContentLoaded', async () => {
	const contenedorDinamico = document.querySelector('.editor-noticia__contenido-bloques.-dinamicos')
	const contenedorCabecera = document.querySelector('.editor-noticia__contenido-bloques.-estaticos')

	const editor = new EditorNoticias(contenedorCabecera, contenedorDinamico)
	await editor.inicializarCabecera()

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

			await editor.agregarBloque(tipo, boton.textContent.trim(), iconoRuta, true)
		})
	})

	window.editorDebug = editor

	console.log('🧩 EditorNoticias inicializado:', editor)

	document.addEventListener('keydown', async e => {
		if (e.key === 'g') {
			const data = editor.obtenerJSON()
			console.log('💾 JSON guardado:', data)
			window.ultimoGuardado = data
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
})
