export default class BloqueAdaptadorModelo {
	constructor(bloqueUI, configBloques) {
		this.bloqueUI = bloqueUI
		this.config = configBloques[bloqueUI.tipo] || {}
	}

	generarConfigModelo() {
		const contenidoConfig = this.config.campos || {}
		const contenido = Object.keys(contenidoConfig).reduce((acc, clave) => {
			acc[clave] = this.bloqueUI.contenido?.[clave] ?? ''
			return acc
		}, {})

		return {
			id: this.bloqueUI.id,
			tipo: this.bloqueUI.tipo,
			texto: this.config.texto || this.bloqueUI.texto || '',
			contenido
		}
	}
}
