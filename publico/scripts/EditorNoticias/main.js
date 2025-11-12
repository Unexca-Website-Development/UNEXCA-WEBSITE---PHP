import EditorUI from './ui/EditorUi.js'
import EditorControlador from './controladores/EditorControlador.js'
import { administradorEventos } from './utilidades/AdministradorEventos.js'

async function iniciarEditor() {
	const contenedor = document.getElementById('editor-principal')
	if (!contenedor) throw new Error('No se encontró el contenedor #editor-principal')

	const ui = new EditorUI(contenedor)
	const controlador = new EditorControlador()

	await ui.renderizarBase()

	// Botones del menú lateral
	const { menuLateral } = ui.obtenerReferencias()
	const btnMenuAbrir = menuLateral.querySelector('#btn-menu-abrir')
	const btnNuevaNoticia = menuLateral.querySelector('#btn-nueva-noticia')
	const btnBuscarNoticia = menuLateral.querySelector('#btn-buscar-noticia')
	const btnNoticiasRecientes = menuLateral.querySelector('#btn-noticias-recientes')
	const btnGuardar = menuLateral.querySelector('#btn-guardar-noticia')
	const btnPublicar = menuLateral.querySelector('#btn-publicar-noticia')

	// Eventos de los botones
	btnNuevaNoticia.addEventListener('click', () => controlador.agregarBloque('parrafo'))
	btnGuardar.addEventListener('click', () => {
		const datos = controlador.obtenerDatos()
		console.log('Guardar datos:', datos)
	})
	btnPublicar.addEventListener('click', () => {
		controlador.establecerEstado('publicado')
		console.log('Noticia publicada')
	})
	btnBuscarNoticia.addEventListener('click', () => {
		console.log('Abrir buscador de noticias')
	})
	btnMenuAbrir.addEventListener('click', () => {
		const principal = document.getElementById('principal')
		principal.classList.toggle('menu-abierto')
	})
	btnNoticiasRecientes.addEventListener('click', () => {
		const contenedorRecientes = menuLateral.querySelector('.menu-editor__contenedor-recientes')
		contenedorRecientes.classList.toggle('activo')
		console.log('Mostrar noticias recientes')
	})
}

document.addEventListener('DOMContentLoaded', iniciarEditor)
