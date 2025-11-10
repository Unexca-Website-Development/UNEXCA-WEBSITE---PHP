import BloqueBase from './BloqueBase.js'

export class BloqueImagen extends BloqueBase {
	constructor() {
		super('imagen', 'Imagen')
		this.campos = { archivo: '', descripcion: '' }
	}
}