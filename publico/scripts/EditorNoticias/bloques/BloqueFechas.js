import BloqueBase from './BloqueBase.js'

export class BloqueFechas extends BloqueBase {
	constructor(texto = 'Información de la noticia') {
		super('fechas', texto)
		this.campos = { creacion: null, modificacion: null, publicacion: null }
	}

	asignarFechas({ creacion, modificacion, publicacion }) {
		this.campos.creacion = creacion ?? this.campos.creacion
		this.campos.modificacion = modificacion ?? this.campos.modificacion
		this.campos.publicacion = publicacion ?? this.campos.publicacion
	}
}
