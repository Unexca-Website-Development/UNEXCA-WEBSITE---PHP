import BloqueBase from './BloqueBase.js'

export class BloqueCita extends BloqueBase {
	constructor() {
		super('cita', 'Cita')
		this.campos = { texto: '', autor: '' }
	}
}