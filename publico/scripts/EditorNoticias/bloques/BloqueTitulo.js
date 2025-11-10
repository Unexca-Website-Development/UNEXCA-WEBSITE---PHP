import BloqueBase from './BloqueBase.js'

export class BloqueTitulo extends BloqueBase {
    constructor() {
        super('titulo', 'Título')
        this.campos = { texto: '' }
    }
}