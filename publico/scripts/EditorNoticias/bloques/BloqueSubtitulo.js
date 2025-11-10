import BloqueBase from './BloqueBase.js'

export class BloqueSubtitulo extends BloqueBase {
	constructor() {
		super('subtitulo', 'Subtítulo')
		this.campos = { texto: '' }
	}
}