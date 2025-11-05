import { crearBloque } from './ConstructorBloques.js'

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
		const bloquesCabecera = [
			{ tipo: 'fechas', texto: 'Información de la noticia', icono: '/imagenes/iconos/icon_calendario.svg' },
			{ tipo: 'parrafo', texto: 'Título de la noticia', icono: '/imagenes/iconos/icon_h1.svg' },
			{ tipo: 'parrafo', texto: 'Descripción de la noticia', icono: '/imagenes/iconos/icon_descripcion.svg' },
			{ tipo: 'imagen', texto: 'Imagen principal', icono: '/imagenes/iconos/icon_imagen.svg' }
		]

		for (const config of bloquesCabecera) {
			const bloque = crearBloque(config.tipo, config.texto, config.icono, this, false)
			this.bloquesCabecera.push(bloque)
			this.contenedorCabecera.appendChild(await bloque.renderizar())
		}
	}

	async agregarBloque(tipo, texto, icono) {
		const bloque = crearBloque(tipo, texto, icono, this)
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