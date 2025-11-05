import { 
	crearSVG,
	generarId, 
	moverElementoAbajo, 
	moverElementoArriba, 
	eliminarElemento,
	crearLabel,
	crearSpan,
	crearTextarea,
	crearInput,
	crearContenedorControl
} from './utilidades.js'

// Clase base
class Bloque {
	constructor(tipo, texto, icono, editor, controles = true) {
		this.tipo = tipo
		this.texto = texto
		this.icono = icono
		this.editor = editor
		this.controles = controles
		this.id = generarId(tipo)
		this.elemento = null
		this.campos = []
	}

	get arrayPadre() {
		if (!this.elemento) return []
		if (this.elemento.parentElement.classList.contains('-estaticos')) {
			return this.editor.bloquesCabecera
		} else {
			return this.editor.bloquesDinamicos
		}
	}

	get contenedorPadre() {
		return this.elemento?.parentElement
	}

	async renderizar() {
		const div = document.createElement('div')
		div.className = 'editor-noticia__bloque'

		const label = await crearLabel(this.texto, this.icono, this.id)
		div.appendChild(label)

		const contenido = await Promise.resolve(this.crearContenido())
		div.appendChild(contenido)

		if (this.controles) {
			const control = await this.crearControl()
			if (control) div.appendChild(control)
		}

		this.elemento = div
		return div
	}

	crearContenido() {
		return document.createElement('div')
	}

	async crearControl(array = null, elemento = null, contenedor = null, className = 'editor-noticia__bloque-control') {
		if (!this.controles) return null

		const arrayUsar = array || this.arrayPadre
		const elementoUsar = elemento || this.elemento
		const contenedorUsar = contenedor || this.contenedorPadre

		const botones = [
			{
				tipo: 'subir',
				icono: '/imagenes/iconos/flecha.svg',
				onClick: () => moverElementoArriba(arrayUsar, this, contenedorUsar, elementoUsar)
			},
			{
				tipo: 'bajar',
				icono: '/imagenes/iconos/flecha.svg',
				onClick: () => moverElementoAbajo(arrayUsar, this, contenedorUsar, elementoUsar)
			},
			{
				tipo: 'borrar',
				icono: '/imagenes/iconos/icon_borrar.svg',
				onClick: () => eliminarElemento(arrayUsar, this, elementoUsar)
			}
		]

		return await crearContenedorControl({ botones, className })
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
		const textarea = crearTextarea({
			id: this.id,
			placeholder: `Escribe ${this.texto.toLowerCase()} aquí...`
		})
		this.campos.push(textarea)
		return textarea
	}
}

class BloqueLista extends Bloque {
	async crearContenido() {
		const contenedor = document.createElement('div')
		contenedor.className = 'editor-noticia__bloque-campos'

		const ul = document.createElement('ul')
		ul.className = 'editor-noticia__lista'

		// Agregar un item inicial
		const primerItem = await this.crearItem(ul)
		ul.appendChild(primerItem)

		contenedor.appendChild(ul)

		// Botón para agregar nuevos items
		const botonAgregar = document.createElement('button')
		botonAgregar.className = 'bloque-titulo bloque-titulo--accion editor-noticia__boton-agregar-bloque'
		botonAgregar.type = 'button'
		
		const svgMas = await crearSVG('/imagenes/iconos/icon_mas.svg')
		botonAgregar.appendChild(svgMas)
		
		const span = crearSpan('Agregar elemento')
		botonAgregar.appendChild(span)

		botonAgregar.addEventListener('click', async () => {
			const nuevoItem = await this.crearItem(ul)
			ul.appendChild(nuevoItem)
			this.actualizarControlesLista(ul)
		})

		contenedor.appendChild(botonAgregar)

		// Actualizar controles según cantidad de elementos
		this.actualizarControlesLista(ul)

		return contenedor
	}

	async crearItem(ul) {
		const li = document.createElement('li')
		li.className = 'editor-noticia__lista-item'

		const textarea = crearTextarea({
			className: 'editor-noticia__campo-texto editor-noticia__campo-texto--lista',
			placeholder: 'Escribe cada elemento en una línea separada...'
		})
		this.campos.push(textarea)
		li.appendChild(textarea)

		// Crear control con array temporal (se reemplazarán los onClick)
		const arrayTemporal = []
		const controlInterno = await this.crearControl(
			arrayTemporal,
			li,
			ul,
			'editor-noticia__bloque-control editor-noticia__bloque-control--interno'
		)
		
		// Reemplazar los onClick para usar el array dinámico y actualizar controles
		if (controlInterno) {
			const botonSubir = controlInterno.querySelector('.-subir')
			const botonBajar = controlInterno.querySelector('.-bajar')
			const botonBorrar = controlInterno.querySelector('.-borrar')
			
			if (botonSubir) {
				botonSubir.onclick = () => {
					const arrayItems = Array.from(ul.children)
					moverElementoArriba(arrayItems, li, ul, li)
				}
			}
			
			if (botonBajar) {
				botonBajar.onclick = () => {
					const arrayItems = Array.from(ul.children)
					moverElementoAbajo(arrayItems, li, ul, li)
				}
			}
			
			if (botonBorrar) {
				botonBorrar.onclick = () => {
					const arrayItems = Array.from(ul.children)
					eliminarElemento(arrayItems, li, li)
					this.actualizarControlesLista(ul)
				}
			}
		}
		
		li.appendChild(controlInterno)

		return li
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
		const contenedor = document.createElement('div')
		
		const inputArchivo = crearInput({
			type: 'file',
			id: this.id,
			className: 'editor-noticia__campo-archivo',
			accept: '.png,.jpg,.jpeg,.webp',
			required: true
		})
		this.campos.push(inputArchivo)
		contenedor.appendChild(inputArchivo)

		const textareaDesc = crearTextarea({
			id: generarId(`${this.tipo}_descripcion`),
			name: generarId(`${this.tipo}_descripcion`),
			placeholder: 'Escribe la descripción de la imagen aquí...'
		})
		this.campos.push(textareaDesc)
		contenedor.appendChild(textareaDesc)

		return contenedor
	}
}

class BloqueCita extends Bloque {
	crearContenido() {
		const contenedor = document.createElement('div')

		const textareaCita = crearTextarea({
			id: this.id,
			placeholder: 'Escribe la cita aquí...'
		})
		this.campos.push(textareaCita)
		contenedor.appendChild(textareaCita)

		const textareaAutor = crearTextarea({
			id: generarId(`${this.tipo}_autor`),
			name: generarId(`${this.tipo}_autor`),
			placeholder: 'Escribe el autor de la cita aquí...'
		})
		this.campos.push(textareaAutor)
		contenedor.appendChild(textareaAutor)

		return contenedor
	}
}

class BloqueFechas extends Bloque {
	async renderizar() {
		const div = document.createElement('div')
		div.className = 'editor-noticia__bloque editor-noticia__bloque--fechas'

		const icono = this.icono || '/imagenes/iconos/icon_calendario.svg'
		const texto = this.texto || 'Información de la noticia'
		const labelPrincipal = await crearLabel(texto, icono)
		div.appendChild(labelPrincipal)
		
		div.appendChild(this.crearContenido())

		if (this.controles) {
			const control = await this.crearControl()
			div.appendChild(control)
		}

		this.elemento = div
		return div
	}

	crearContenido() {
		const contenedor = document.createElement('div')
		contenedor.className = 'editor-noticia__grupo-fechas'

		const campos = [
			{ id: 'fecha_creacion', nombre: 'Fecha de creación', readonly: true },
			{ id: 'fecha_publicacion', nombre: 'Fecha de publicación', readonly: false },
			{ id: 'fecha_modificacion', nombre: 'Última modificación', readonly: true }
		]

		campos.forEach(c => {
			const grupo = document.createElement('div')
			grupo.className = 'editor-noticia__campo-fecha'

			const label = document.createElement('label')
			label.setAttribute('for', c.id)
			label.textContent = c.nombre
			grupo.appendChild(label)

			const input = crearInput({
				type: 'date',
				id: c.id,
				name: c.id,
				readOnly: c.readonly
			})
			this.campos.push(input)
			grupo.appendChild(input)

			contenedor.appendChild(grupo)
		})

		return contenedor
	}
}

export {Bloque, BloqueCita, BloqueImagen, BloqueLista, BloqueTexto, BloqueFechas};