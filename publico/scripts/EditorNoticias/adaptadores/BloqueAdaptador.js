export default class BloqueAdaptador {
	constructor(bloqueLogico, configUI) {
		this.bloque = bloqueLogico
		this.config = configUI[bloqueLogico.tipo] || {}
	}

	generarConfigUI() {
		return {
			id: this.bloque.id,
			tipo: this.bloque.tipo,
			texto: this.bloque.texto,
			icono: this.config.icono || '',
			placeholder: this.config.placeholder || '',
			inputs: this.config.inputs || [],
			requerido: this.config.requerido || false,
			contenido: { ...this.bloque.campos }
		}
	}
}
