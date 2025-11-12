export default class BloqueAdaptadorModelo {
	constructor(bloqueUI, configBloques) {
		this.bloqueUI = bloqueUI
		this.config = configBloques[bloqueUI.tipo] || {}
	}

	generarConfigModelo() {
		const camposConfig = this.config.campos || {}

		const campos = Object.keys(camposConfig).reduce((acc, clave) => {
			const valorUI = this.bloqueUI.contenido?.[clave]
			acc[clave] = {
				valorInicial: valorUI ?? camposConfig[clave].valorInicial ?? '',
				requerido: camposConfig[clave].requerido ?? false
			}
			return acc
		}, {})

		return {
			id: this.bloqueUI.id,
			tipo: this.bloqueUI.tipo,
			texto: this.config.texto || this.bloqueUI.texto || '',
			campos
		}
	}
}
