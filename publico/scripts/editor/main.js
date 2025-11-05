import { EditorNoticias } from './EditorNoticias.js'
import { normalizarTexto } from './utilidades.js'
import { obtenerIcono, esTipoValido } from './ConstructorBloques.js'

document.addEventListener('DOMContentLoaded', async () => {
	const contenedorDinamico = document.querySelector('.editor-noticia__contenido-bloques.-dinamicos')
	const contenedorCabecera = document.querySelector('.editor-noticia__contenido-bloques.-estaticos')

	const editor = new EditorNoticias(contenedorCabecera, contenedorDinamico)
	await editor.inicializarCabecera()

	const botones = document.querySelectorAll('.agregar-bloque__opcion')
	botones.forEach(boton => {
		boton.addEventListener('click', async () => {
			const tipo = normalizarTexto(boton.textContent.trim())
			
			if (!esTipoValido(tipo)) {
				console.warn(`Tipo de bloque no válido: ${tipo}`)
				return
			}

			const iconoRuta = obtenerIcono(tipo)
			await editor.agregarBloque(tipo, boton.textContent.trim(), iconoRuta)
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