export default class BloqueAdaptadorUI {
	constructor(bloqueLogico, configUI) {
		this.bloque = bloqueLogico
		this.uiConfig = configUI[bloqueLogico.tipo]?.ui || {}
	}

	generarConfigUI() {
		return {
			id: this.bloque.id,
			tipo: this.bloque.tipo,
			texto: this.bloque.texto,
			icono: this.uiConfig.icono || '',
			inputs: this.uiConfig.inputs || [],
			requerido: this.bloque.requerido || false,
			contenido: { ...this.bloque.campos }
		}
	}
}
