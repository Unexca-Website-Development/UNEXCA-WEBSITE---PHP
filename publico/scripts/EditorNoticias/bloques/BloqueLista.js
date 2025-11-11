import BloqueBase from './BloqueBase.js'

export class BloqueLista extends BloqueBase {
	constructor() {
		super('lista', 'Lista')
		this.campos = { items: [] }
	}

	agregarItem(item) {
		this.campos.items.push(item)
	}

	eliminarItem(index) {
		if (index >= 0 && index < this.campos.items.length) {
			this.campos.items.splice(index, 1)
		}
	}
}
