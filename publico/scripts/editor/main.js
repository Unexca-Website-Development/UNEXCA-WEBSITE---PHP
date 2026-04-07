import { EditorNoticias } from './modulos/EditorNoticias.js'
import { normalizarTexto } from './utilidades.js'
import { obtenerIcono, esTipoValido } from './bloques/ConstructorBloques.js'
import { menuLateral } from './menu/MenuLateral.js'
import { EditorControlador } from './modulos/EditorControlador.js'
import { noticiasAPI } from './api/NoticiasAPI.js'

document.addEventListener('DOMContentLoaded', async () => {
	const contenedorDinamico = document.querySelector('.editor-noticia__contenido-bloques.-dinamicos')
	const contenedorCabecera = document.querySelector('.editor-noticia__contenido-bloques.-estaticos')

	const editor = new EditorNoticias(contenedorCabecera, contenedorDinamico)
	await editor.inicializarCabecera()

	// Inicializar menú lateral (maneja sus propios eventos y emite eventos para acciones)
	menuLateral.inicializar()

	// Crear controlador que maneja todo el flujo del editor
	const controlador = new EditorControlador(editor)
	controlador.inicializar()

	// Cargar noticia desde URL si hay parámetro ?id=X
	const urlParams = new URLSearchParams(window.location.search)
	const noticiaId = urlParams.get('id')
	if (noticiaId) {
		try {
			// TODO: Cuando el endpoint PHP esté listo, descomentar:
			// const data = await noticiasAPI.cargarNoticia(parseInt(noticiaId))
			// await editor.cargarNoticia(data)
			// controlador.noticiaId = parseInt(noticiaId)
			// console.log('Noticia cargada desde servidor:', noticiaId)
			
			console.log('Cargar noticia ID:', noticiaId, '(endpoint pendiente)')
		} catch (error) {
			console.error('Error al cargar noticia:', error)
		}
	}

	// Botones rápidos de agregar bloques
	document.querySelectorAll('.agregar-bloque__opcion').forEach(boton => {
		boton.addEventListener('click', async () => {
			const tipo = normalizarTexto(boton.textContent.trim())
			if (!esTipoValido(tipo)) return
			const iconoRuta = obtenerIcono(tipo)
			await editor.agregarBloque(tipo, boton.textContent.trim(), iconoRuta)
		})
	})

	window.editorDebug = editor
	console.log('🧩 EditorNoticias inicializado')

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