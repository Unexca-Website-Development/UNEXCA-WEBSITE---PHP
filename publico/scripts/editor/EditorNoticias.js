import { BloqueTexto, BloqueLista, BloqueImagen, BloqueCita, BloqueFechas } from './Bloques.js'

class EditorNoticias {
	constructor(contenedorCabecera, contenedorDinamico) {
		this.contenedorCabecera = contenedorCabecera
		this.contenedorDinamico = contenedorDinamico
		this.bloquesCabecera = []
		this.bloquesDinamicos = []
		this.fechaCreacion = new Date()
		this.fechaModificacion = null
		this.fechaPublicacion = null
	}

	async inicializarCabecera() {
		const bloqueFechas = new BloqueFechas('fechas', 'Información de la noticia', '/imagenes/iconos/icon_calendario.svg', this, false)
		this.bloquesCabecera.push(bloqueFechas)
		this.contenedorCabecera.appendChild(await bloqueFechas.renderizar())

		const bloqueTitulo = new BloqueTexto('titulo', 'Título de la noticia', '/imagenes/iconos/icon_h1.svg', this, false)
		this.bloquesCabecera.push(bloqueTitulo)
		this.contenedorCabecera.appendChild(await bloqueTitulo.renderizar())

		const bloqueDescripcion = new BloqueTexto('descripcion', 'Descripción de la noticia', '/imagenes/iconos/icon_descripcion.svg', this, false)
		this.bloquesCabecera.push(bloqueDescripcion)
		this.contenedorCabecera.appendChild(await bloqueDescripcion.renderizar())

		const bloqueImagen = new BloqueImagen('imagen', 'Imagen principal', '/imagenes/iconos/icon_imagen.svg', this, false)
		this.bloquesCabecera.push(bloqueImagen)
		this.contenedorCabecera.appendChild(await bloqueImagen.renderizar())
	}

	async agregarBloque(tipo, texto, icono) {
		let bloque
		switch(tipo){
			case 'subtitulo':
			case 'parrafo':
				bloque = new BloqueTexto(tipo, texto, icono, this)
				break
			case 'lista':
				bloque = new BloqueLista(tipo, texto, icono, this)
				break
			case 'imagen':
				bloque = new BloqueImagen(tipo, texto, icono, this)
				break
			case 'cita':
				bloque = new BloqueCita(tipo, texto, icono, this)
				break
			default:
				bloque = new BloqueTexto(tipo, texto, icono, this)
		}
		this.bloquesDinamicos.push(bloque)
		this.contenedorDinamico.appendChild(await bloque.renderizar())
		return bloque
	}

	obtenerJSON() {
		return {
			cabecera: Object.fromEntries(this.bloquesCabecera.map(b => [b.tipo, b.obtenerContenido()])),
			bloques: this.bloquesDinamicos.map(b => b.obtenerContenido())
		}
	}

	async cargarNoticia(data) {
		this.contenedorCabecera.innerHTML = ''
		this.contenedorDinamico.innerHTML = ''
		this.bloquesCabecera = []
		this.bloquesDinamicos = []

		await this.inicializarCabecera()

		if(data.cabecera){
			for(const bloque of this.bloquesCabecera){
				if(data.cabecera[bloque.tipo]) bloque.asignarContenido(data.cabecera[bloque.tipo])
			}
		}

		if(data.bloques){
			for(const b of data.bloques){
				const bloque = await this.agregarBloque(b.tipo, b.texto, b.icono)
				if(b.contenido) bloque.asignarContenido(b.contenido)
			}
		}
	}
}

export { EditorNoticias }