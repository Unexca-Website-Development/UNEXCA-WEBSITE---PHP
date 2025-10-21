let contadorBloques = 0

function generarId(tipo) {
	contadorBloques++
	return `${tipo}_${Date.now()}_${contadorBloques}`
}

async function crearSVG(ruta) {
	const respuesta = await fetch(ruta)
	const svgTexto = await respuesta.text()
	const contenedor = document.createElement('div')
	contenedor.innerHTML = svgTexto.trim()
	return contenedor.firstChild
}

function crearBloqueTexto(tipo, texto) {
	const bloque = document.createElement('textarea')
	bloque.className = 'editor-noticia__campo-texto'
	bloque.id = generarId(tipo)
	bloque.placeholder = `Escribe ${texto.toLowerCase()} aquí...`
	bloque.required = true
	return bloque
}

function crearBloqueLista(tipo) {
	const bloque = document.createElement('textarea')
	bloque.className = 'editor-noticia__campo-texto editor-noticia__campo-texto--lista'
	bloque.id = generarId(tipo)
	bloque.placeholder = 'Escribe cada elemento en una línea separada...'
	bloque.required = true
	return bloque
}

function crearBloqueImagen(tipo) {
	const fragmento = document.createDocumentFragment()

	const inputArchivo = document.createElement('input')
	inputArchivo.className = 'editor-noticia__campo-archivo'
	inputArchivo.type = 'file'
	inputArchivo.id = generarId(tipo)
	inputArchivo.accept = '.png,.jpg,.jpeg,.webp'
	inputArchivo.required = true
	fragmento.appendChild(inputArchivo)

	const textareaDesc = document.createElement('textarea')
	textareaDesc.className = 'editor-noticia__campo-texto'
	textareaDesc.id = generarId(`${tipo}_descripcion`)
	textareaDesc.name = textareaDesc.id
	textareaDesc.placeholder = 'Escribe la descripción de la imagen aquí...'
	textareaDesc.required = true
	fragmento.appendChild(textareaDesc)

	return fragmento
}

function crearBloqueCita(tipo) {
	const fragmento = document.createDocumentFragment()

	const textareaCita = document.createElement('textarea')
	textareaCita.className = 'editor-noticia__campo-texto'
	textareaCita.id = generarId(tipo)
	textareaCita.placeholder = 'Escribe la cita aquí...'
	textareaCita.required = true
	fragmento.appendChild(textareaCita)

	const textareaAutor = document.createElement('textarea')
	textareaAutor.className = 'editor-noticia__campo-texto'
	textareaAutor.id = generarId(`${tipo}_autor`)
	textareaAutor.name = textareaAutor.id
	textareaAutor.placeholder = 'Escribe el autor de la cita aquí...'
	textareaAutor.required = true
	fragmento.appendChild(textareaAutor)

	return fragmento
}

async function crearControl(contenedor) {
	const controlDiv = document.createElement('div')
	controlDiv.className = 'editor-noticia__bloque-control'

	const botonesDiv = document.createElement('div')
	botonesDiv.className = 'editor-noticia__bloque-control-contenedor'

	const botonSubir = document.createElement('button')
	botonSubir.className = 'editor-noticia__boton-control -subir'
	botonSubir.type = 'button'
	botonSubir.appendChild(await crearSVG('/imagenes/iconos/flecha.svg'))
	botonSubir.addEventListener('click', (e) => {
		const bloque = e.target.closest('.editor-noticia__bloque')
		if (!bloque) return
		const anterior = bloque.previousElementSibling
		if (anterior) contenedor.insertBefore(bloque, anterior)
	})
	botonesDiv.appendChild(botonSubir)

	const botonBajar = document.createElement('button')
	botonBajar.className = 'editor-noticia__boton-control -bajar'
	botonBajar.type = 'button'
	botonBajar.appendChild(await crearSVG('/imagenes/iconos/flecha.svg'))
	botonBajar.addEventListener('click', (e) => {
		const bloque = e.target.closest('.editor-noticia__bloque')
		if (!bloque) return
		const siguiente = bloque.nextElementSibling
		if (siguiente) contenedor.insertBefore(siguiente, bloque)
	})
	botonesDiv.appendChild(botonBajar)

	const botonBorrar = document.createElement('button')
	botonBorrar.className = 'editor-noticia__boton-control -borrar'
	botonBorrar.type = 'button'
	botonBorrar.appendChild(await crearSVG('/imagenes/iconos/icon_borrar.svg'))
	botonBorrar.addEventListener('click', (e) => {
		const bloque = e.target.closest('.editor-noticia__bloque')
		if (bloque) bloque.remove()
	})
	botonesDiv.appendChild(botonBorrar)

	controlDiv.appendChild(botonesDiv)
	return controlDiv
}

async function crearBloque(tipo, texto, input, icono, contenedor) {
	const div = document.createElement('div')
	div.className = 'editor-noticia__bloque'

	const label = document.createElement('label')
	label.className = 'bloque-titulo'
	label.setAttribute('for', tipo)

	const svg = await crearSVG(icono)
	label.appendChild(svg)

	const span = document.createElement('span')
	span.className = 'bloque-titulo__texto'
	span.textContent = texto
	label.appendChild(span)

	let bloque
	switch (input) {
		case 'Titulo':
		case 'Descripcion':
		case 'Subtitulo':
		case 'Parrafo':
			bloque = crearBloqueTexto(tipo, texto)
			break
		case 'Cita':
			bloque = crearBloqueCita(tipo)
			break
		case 'Lista':
			bloque = crearBloqueLista(tipo)
			break
		case 'Imagen':
			bloque = crearBloqueImagen(tipo)
			break
	}

	div.appendChild(label)
	div.appendChild(bloque)

	const control = await crearControl(contenedor)
	div.appendChild(control)

	return div
}

document.addEventListener('DOMContentLoaded', () => {
	const botones = document.querySelectorAll('.agregar-bloque__opcion')
	const contenedorBloques = document.querySelector('.editor-noticia__contenido-bloques')

	botones.forEach(boton => {
		boton.addEventListener('click', async () => {
			const tipo = boton.textContent.trim().replace(/\s+/g, '_')
			let inputTipo, iconoRuta

			switch (tipo) {
				case 'Subtítulo':
					inputTipo = 'Subtitulo'
					iconoRuta = '/imagenes/iconos/icon_h2.svg'
					break
				case 'Párrafo':
					inputTipo = 'Parrafo'
					iconoRuta = '/imagenes/iconos/icon_parrafo.svg'
					break
				case 'Imagen':
					inputTipo = 'Imagen'
					iconoRuta = '/imagenes/iconos/icon_imagen.svg'
					break
				case 'Cita':
					inputTipo = 'Cita'
					iconoRuta = '/imagenes/iconos/icon_cita.svg'
					break
				case 'Lista':
					inputTipo = 'Lista'
					iconoRuta = '/imagenes/iconos/icon_lista.svg'
					break
				default:
					return
			}

			const nuevoBloque = await crearBloque(tipo.toLowerCase(), tipo, inputTipo, iconoRuta, contenedorBloques)
			contenedorBloques.appendChild(nuevoBloque)
		})
	})
})
