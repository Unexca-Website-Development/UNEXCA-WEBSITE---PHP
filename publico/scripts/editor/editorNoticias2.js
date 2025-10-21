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
		botonSubir.addEventListener('click', () => this.editor.moverBloqueArriba(this))
		botonesDiv.appendChild(botonSubir)

		const botonBajar = document.createElement('button')
		botonBajar.className = 'editor-noticia__boton-control -bajar'
		botonBajar.type = 'button'
		botonBajar.appendChild(await crearSVG('/imagenes/iconos/flecha.svg'))
		botonBajar.addEventListener('click', () => this.editor.moverBloqueAbajo(this))
		botonesDiv.appendChild(botonBajar)

		const botonBorrar = document.createElement('button')
		botonBorrar.className = 'editor-noticia__boton-control -borrar'
		botonBorrar.type = 'button'
		botonBorrar.appendChild(await crearSVG('/imagenes/iconos/icon_borrar.svg'))
		botonBorrar.addEventListener('click', () => this.editor.eliminarBloque(this))
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
		const textarea = document.createElement('textarea')
		textarea.className = 'editor-noticia__campo-texto editor-noticia__campo-texto--lista'
		textarea.id = this.id
		textarea.placeholder = 'Escribe cada elemento en una línea separada...'
		textarea.required = true
		this.campos.push(textarea)
		return textarea
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

// Editor Noticias
class EditorNoticias {
	constructor(contenedor) {
		this.contenedor = contenedor
		this.bloques = []
		this.fechaCreacion = new Date()
		this.fechaModificacion = null
		this.fechaPublicacion = null
	}

	async agregarBloque(tipo, texto, icono) {
		let bloque
		switch (tipo) {
			case 'Subtitulo':
			case 'Titulo':
			case 'Descripcion':
			case 'Parrafo':
				bloque = new BloqueTexto(tipo, texto, icono, this)
				break
			case 'Lista':
				bloque = new BloqueLista(tipo, texto, icono, this)
				break
			case 'Imagen':
				bloque = new BloqueImagen(tipo, texto, icono, this)
				break
			case 'Cita':
				bloque = new BloqueCita(tipo, texto, icono, this)
				break
			default:
				bloque = new BloqueTexto(tipo, texto, icono, this)
		}
		const elemento = await bloque.renderizar()
		this.bloques.push(bloque)
		this.contenedor.appendChild(elemento)
		this.actualizarFechaModificacion()
		return bloque
	}

	eliminarBloque(bloque) {
		const index = this.bloques.indexOf(bloque)
		if (index > -1) {
			this.bloques.splice(index, 1)
			if (bloque.elemento) bloque.elemento.remove()
			this.actualizarFechaModificacion()
		}
	}

	moverBloqueArriba(bloque) {
		const index = this.bloques.indexOf(bloque)
		if (index > 0) {
			[this.bloques[index - 1], this.bloques[index]] = [this.bloques[index], this.bloques[index - 1]]
			this.contenedor.insertBefore(bloque.elemento, bloque.elemento.previousElementSibling)
			this.actualizarFechaModificacion()
		}
	}

	moverBloqueAbajo(bloque) {
		const index = this.bloques.indexOf(bloque)
		if (index > -1 && index < this.bloques.length - 1) {
			[this.bloques[index], this.bloques[index + 1]] = [this.bloques[index + 1], this.bloques[index]]
			const siguiente = bloque.elemento.nextElementSibling.nextElementSibling
			this.contenedor.insertBefore(bloque.elemento, siguiente)
			this.actualizarFechaModificacion()
		}
	}

	obtenerJSON() {
		return {
			fechaCreacion: this.fechaCreacion,
			fechaModificacion: this.fechaModificacion,
			fechaPublicacion: this.fechaPublicacion,
			bloques: this.bloques.map(b => b.obtenerContenido())
		}
	}

	guardarNoticia() {
		this.fechaModificacion = new Date()
		return this.obtenerJSON()
	}

	publicarNoticia() {
		this.fechaPublicacion = new Date()
		this.actualizarFechaModificacion()
		return this.obtenerJSON()
	}

	actualizarFechaModificacion() {
		this.fechaModificacion = new Date()
	}

	async cargarNoticia(data) {
		this.contenedor.innerHTML = ''
		this.bloques = []
		for (const b of data.bloques) {
			const bloque = await this.agregarBloque(b.tipo, b.texto, b.icono)
			if (b.contenido) bloque.asignarContenido(b.contenido)
		}
		this.fechaCreacion = new Date(data.fechaCreacion)
		this.fechaModificacion = new Date(data.fechaModificacion)
		this.fechaPublicacion = data.fechaPublicacion ? new Date(data.fechaPublicacion) : null
	}
}

document.addEventListener('DOMContentLoaded', () => {
	const contenedorBloques = document.querySelector('.editor-noticia__contenido-bloques')
	const editor = new EditorNoticias(contenedorBloques)

	const botones = document.querySelectorAll('.agregar-bloque__opcion')
	botones.forEach(boton => {
		boton.addEventListener('click', async () => {
			const tipo = boton.textContent.trim().replace(/\s+/g, '_')
			let iconoRuta

			switch (tipo) {
				case 'Subtítulo':
					iconoRuta = '/imagenes/iconos/icon_h2.svg'
					break
				case 'Párrafo':
					iconoRuta = '/imagenes/iconos/icon_parrafo.svg'
					break
				case 'Imagen':
					iconoRuta = '/imagenes/iconos/icon_imagen.svg'
					break
				case 'Cita':
					iconoRuta = '/imagenes/iconos/icon_cita.svg'
					break
				case 'Lista':
					iconoRuta = '/imagenes/iconos/icon_lista.svg'
					break
				default:
					return
			}

			await editor.agregarBloque(tipo.replace('ó', 'o').toLowerCase(), tipo, iconoRuta)
		})
	})
})