import { 
	crearSVG,
	generarId, 
	moverElementoAbajo, 
	moverElementoArriba, 
	eliminarElemento 
} from './utilidades.js'

// Clase base
class Bloque {
	constructor(tipo, texto, icono, editor) {
		this.tipo = tipo
		this.texto = texto
		this.icono = icono
		this.editor = editor
		this.id = generarId(tipo)
		this.elemento = null
		this.campos = []
	}

	async renderizar() {
		const div = document.createElement('div')
		div.className = 'editor-noticia__bloque'

		const label = document.createElement('label')
		label.className = 'bloque-titulo'
		label.setAttribute('for', this.id)

		const svg = await crearSVG(this.icono)
		label.appendChild(svg)

		const span = document.createElement('span')
		span.className = 'bloque-titulo__texto'
		span.textContent = this.texto
		label.appendChild(span)

		const contenido = this.crearContenido()
		div.appendChild(label)
		div.appendChild(contenido)

		const control = await this.crearControl()
		div.appendChild(control)
		this.elemento = div
		return div
	}

	crearContenido() {
		return document.createElement('div')
	}

	async crearControl() {
		const controlDiv = document.createElement('div')
		controlDiv.className = 'editor-noticia__bloque-control'

		const botonesDiv = document.createElement('div')
		botonesDiv.className = 'editor-noticia__bloque-control-contenedor'

		const botonSubir = document.createElement('button')
		botonSubir.className = 'editor-noticia__boton-control -subir'
		botonSubir.type = 'button'
		botonSubir.appendChild(await crearSVG('/imagenes/iconos/flecha.svg'))
		botonSubir.addEventListener('click', () => moverElementoArriba(this.editor.bloques, this, this.editor.contenedor, this.elemento))
		botonesDiv.appendChild(botonSubir)

		const botonBajar = document.createElement('button')
		botonBajar.className = 'editor-noticia__boton-control -bajar'
		botonBajar.type = 'button'
		botonBajar.appendChild(await crearSVG('/imagenes/iconos/flecha.svg'))
		botonBajar.addEventListener('click', () => moverElementoAbajo(this.editor.bloques, this, this.editor.contenedor, this.elemento))
		botonesDiv.appendChild(botonBajar)

		const botonBorrar = document.createElement('button')
		botonBorrar.className = 'editor-noticia__boton-control -borrar'
		botonBorrar.type = 'button'
		botonBorrar.appendChild(await crearSVG('/imagenes/iconos/icon_borrar.svg'))
		botonBorrar.addEventListener('click', () => eliminarElemento(this.editor.bloques, this, this.elemento))
		botonesDiv.appendChild(botonBorrar)

		controlDiv.appendChild(botonesDiv)
		return controlDiv
	}

	obtenerContenido() {
		const datos = this.campos.map(c => c.type === 'file' ? (c.files[0]?.name || '') : c.value)
		return {
			id: this.id,
			tipo: this.tipo,
			texto: this.texto,
			icono: this.icono,
			contenido: datos
		}
	}

	asignarContenido(datos) {
		this.campos.forEach((c, i) => {
			if (c.type === 'file') return
			c.value = datos[i] || ''
		})
	}
}

// Subclases de bloques específicos
class BloqueTexto extends Bloque {
	crearContenido() {
		const textarea = document.createElement('textarea')
		textarea.className = 'editor-noticia__campo-texto'
		textarea.id = this.id
		textarea.placeholder = `Escribe ${this.texto.toLowerCase()} aquí...`
		textarea.required = true
		this.campos.push(textarea)
		return textarea
	}
}

class BloqueLista extends Bloque {
	crearContenido() {
		const contenedor = document.createElement('div')
		contenedor.className = 'editor-noticia__bloque-campos'

		const ul = document.createElement('ul')
		ul.className = 'editor-noticia__lista'

		// Agregar un item inicial
		const primerItem = this.crearItem(ul)
		ul.appendChild(primerItem)

		contenedor.appendChild(ul)

		// Botón para agregar nuevos items
		const botonAgregar = document.createElement('button')
		botonAgregar.className = 'bloque-titulo bloque-titulo--accion editor-noticia__boton-agregar-bloque'
		botonAgregar.type = 'button'
		crearSVG('/imagenes/iconos/icon_mas.svg').then(svg => botonAgregar.appendChild(svg))

		const span = document.createElement('span')
		span.className = 'bloque-titulo__texto'
		span.textContent = 'Agregar elemento'
		botonAgregar.appendChild(span)

		botonAgregar.addEventListener('click', () => {
			const nuevoItem = this.crearItem(ul)
			ul.appendChild(nuevoItem)
			this.actualizarControlesLista(ul)
		})

		contenedor.appendChild(botonAgregar)

		// Actualizar controles según cantidad de elementos
		this.actualizarControlesLista(ul)

		return contenedor
	}

	crearItem(ul) {
		const li = document.createElement('li')
		li.className = 'editor-noticia__lista-item'

		const textarea = document.createElement('textarea')
		textarea.className = 'editor-noticia__campo-texto editor-noticia__campo-texto--lista'
		textarea.placeholder = 'Escribe cada elemento en una línea separada...'
		textarea.required = true
		this.campos.push(textarea)
		li.appendChild(textarea)

		const controlInterno = this.crearControlInterno(li, ul)
		li.appendChild(controlInterno)

		return li
	}

	crearControlInterno(item, ul) {
		const controlDiv = document.createElement('div')
		controlDiv.className = 'editor-noticia__bloque-control editor-noticia__bloque-control--interno'

		const botonesDiv = document.createElement('div')
		botonesDiv.className = 'editor-noticia__bloque-control-contenedor'

		const botonSubir = document.createElement('button')
		botonSubir.type = 'button'
		botonSubir.className = 'editor-noticia__boton-control -subir'
		crearSVG('/imagenes/iconos/flecha.svg').then(svg => botonSubir.appendChild(svg))
		botonSubir.addEventListener('click', () => moverElementoArriba(Array.from(ul.children), item, ul, item))
		botonesDiv.appendChild(botonSubir)

		const botonBajar = document.createElement('button')
		botonBajar.type = 'button'
		botonBajar.className = 'editor-noticia__boton-control -bajar'
		crearSVG('/imagenes/iconos/flecha.svg').then(svg => botonBajar.appendChild(svg))
		botonBajar.addEventListener('click', () => moverElementoAbajo(Array.from(ul.children), item, ul, item))
		botonesDiv.appendChild(botonBajar)

		const botonBorrar = document.createElement('button')
		botonBorrar.type = 'button'
		botonBorrar.className = 'editor-noticia__boton-control -borrar'
		crearSVG('/imagenes/iconos/icon_borrar.svg').then(svg => botonBorrar.appendChild(svg))
		botonBorrar.addEventListener('click', () => {
			eliminarElemento(Array.from(ul.children), item, item)
			this.actualizarControlesLista(ul)
		})
		botonesDiv.appendChild(botonBorrar)

		controlDiv.appendChild(botonesDiv)
		return controlDiv
	}

	actualizarControlesLista(ul) {
		const mostrar = ul.children.length > 1
		Array.from(ul.children).forEach(li => {
			const control = li.querySelector('.editor-noticia__bloque-control--interno')
			control.style.display = mostrar ? 'flex' : 'none'
		})
	}
}

class BloqueImagen extends Bloque {
	crearContenido() {
		const fragmento = document.createDocumentFragment()
		const inputArchivo = document.createElement('input')
		inputArchivo.className = 'editor-noticia__campo-archivo'
		inputArchivo.type = 'file'
		inputArchivo.id = this.id
		inputArchivo.accept = '.png,.jpg,.jpeg,.webp'
		inputArchivo.required = true
		this.campos.push(inputArchivo)
		fragmento.appendChild(inputArchivo)

		const textareaDesc = document.createElement('textarea')
		textareaDesc.className = 'editor-noticia__campo-texto'
		textareaDesc.id = generarId(`${this.tipo}_descripcion`)
		textareaDesc.name = textareaDesc.id
		textareaDesc.placeholder = 'Escribe la descripción de la imagen aquí...'
		textareaDesc.required = true
		this.campos.push(textareaDesc)
		fragmento.appendChild(textareaDesc)

		return fragmento
	}
}

class BloqueCita extends Bloque {
	crearContenido() {
		const fragmento = document.createDocumentFragment()

		const textareaCita = document.createElement('textarea')
		textareaCita.className = 'editor-noticia__campo-texto'
		textareaCita.id = this.id
		textareaCita.placeholder = 'Escribe la cita aquí...'
		textareaCita.required = true
		this.campos.push(textareaCita)
		fragmento.appendChild(textareaCita)

		const textareaAutor = document.createElement('textarea')
		textareaAutor.className = 'editor-noticia__campo-texto'
		textareaAutor.id = generarId(`${this.tipo}_autor`)
		textareaAutor.name = textareaAutor.id
		textareaAutor.placeholder = 'Escribe el autor de la cita aquí...'
		textareaAutor.required = true
		this.campos.push(textareaAutor)
		fragmento.appendChild(textareaAutor)

		return fragmento
	}
}

export {Bloque, BloqueCita, BloqueImagen, BloqueLista, BloqueTexto};