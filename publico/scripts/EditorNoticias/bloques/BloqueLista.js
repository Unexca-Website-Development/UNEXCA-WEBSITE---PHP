import BloqueBase from './BloqueBase.js'

export class BloqueLista extends BloqueBase {
	constructor() {
		super('lista', 'Lista')
		this.campos = { items: [] } // Cada item puede ser un string o un objeto más complejo si se desea
	}

	agregarItem(item) {
		this.campos.push(item)
	}

	eliminarItem(index) {
		if (index >= 0 && index < this.campos.length) {
			this.campos.splice(index, 1)
		}
	}
}