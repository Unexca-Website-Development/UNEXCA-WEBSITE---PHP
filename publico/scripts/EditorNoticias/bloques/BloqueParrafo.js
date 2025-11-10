import BloqueBase from "./BloqueBase.js"

export class BloqueParrafo extends BloqueBase {
	constructor() {
		super('parrafo', 'Párrafo')
		this.campos = { texto: '' }
	}
}