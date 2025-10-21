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