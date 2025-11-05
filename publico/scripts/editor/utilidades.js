let contadorBloques = 0

export function generarId(tipo) {
	contadorBloques++
	return `${tipo}_${Date.now()}_${contadorBloques}`
}

export async function crearSVG(ruta) {
	const respuesta = await fetch(ruta)
	const svgTexto = await respuesta.text()
	const contenedor = document.createElement('div')
	contenedor.innerHTML = svgTexto.trim()
	return contenedor.firstChild
}

export function eliminarElemento(array, elemento, nodo) {
	const index = array.indexOf(elemento)
	if (index > -1) {
		array.splice(index, 1)
		if (nodo) nodo.remove()
	}
}

export function moverElementoArriba(array, elemento, contenedor, nodo) {
	const index = array.indexOf(elemento)
	if (index > 0) {
		[array[index - 1], array[index]] = [array[index], array[index - 1]]
		contenedor.insertBefore(nodo, nodo.previousElementSibling)
	}
}

export function moverElementoAbajo(array, elemento, contenedor, nodo) {
	const index = array.indexOf(elemento)
	if (index > -1 && index < array.length - 1) {
		[array[index], array[index + 1]] = [array[index + 1], array[index]]
		const siguiente = nodo.nextElementSibling.nextElementSibling
		contenedor.insertBefore(nodo, siguiente)
	}
}

export function normalizarTexto(texto) {
    return texto
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
}

export async function crearLabel(texto, icono, forId = null, className = 'bloque-titulo') {
	const label = document.createElement('label')
	label.className = className
	if (forId) label.setAttribute('for', forId)

	const svg = await crearSVG(icono)
	label.appendChild(svg)

	const span = crearSpan(texto, 'bloque-titulo__texto')
	label.appendChild(span)

	return label
}

export function crearSpan(texto, className = '') {
	const span = document.createElement('span')
	if (className) span.className = className
	span.textContent = texto
	return span
}

export function crearTextarea({ id, className = 'editor-noticia__campo-texto', placeholder = '', required = true }) {
	const textarea = document.createElement('textarea')
	textarea.className = className
	if (id) textarea.id = id
	if (placeholder) textarea.placeholder = placeholder
	textarea.required = required
	return textarea
}

export function crearInput({ type, id, className = '', name = null, required = false, readOnly = false, accept = null }) {
	const input = document.createElement('input')
	input.type = type
	if (id) input.id = id
	if (className) input.className = className
	if (name) input.name = name
	if (required) input.required = required
	if (readOnly) input.readOnly = readOnly
	if (accept) input.accept = accept
	return input
}

export async function crearBotonControl({ tipo, icono, onClick }) {
	const boton = document.createElement('button')
	boton.className = `editor-noticia__boton-control -${tipo}`
	boton.type = 'button'
	
	const svg = await crearSVG(icono)
	boton.appendChild(svg)
	
	if (onClick) {
		boton.addEventListener('click', onClick)
	}
	
	return boton
}

export async function crearContenedorControl({ botones, className = 'editor-noticia__bloque-control' }) {
	const controlDiv = document.createElement('div')
	controlDiv.className = className

	const botonesDiv = document.createElement('div')
	botonesDiv.className = 'editor-noticia__bloque-control-contenedor'

	for (const configBoton of botones) {
		const boton = await crearBotonControl(configBoton)
		botonesDiv.appendChild(boton)
	}

	controlDiv.appendChild(botonesDiv)
	return controlDiv
}